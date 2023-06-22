<?php

namespace App\Http\Controllers\Api;

use App\Repositories\InviteRepository;
use App\Repositories\SmsCodeRepository;
use App\Repositories\UserIMIERepositoryImp;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Kavenegar;
use App\Models\SmsCode;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class LoginController extends Controller
{
    private $user, $invite, $sms_code_repository,$IMIERepositoryImp,$per_page = 10;

    /**
     * LoginController constructor.
     * @param UserRepository $user
     * @param InviteRepository $invite
     * @param SmsCodeRepository $sms_code_repository
     */
    public function __construct(UserRepository $user, InviteRepository $invite, SmsCodeRepository $sms_code_repository,UserIMIERepositoryImp $IMIERepositoryImp)
    {
        $this->user = $user;
        $this->invite = $invite;
        $this->sms_code_repository = $sms_code_repository;
        $this->IMIERepositoryImp=$IMIERepositoryImp;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sendCode(Request $request)
    {
// kavenegar::VerifyLookup($phone_number, $code,null,null,"fakoor",null);
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'IMEI' =>'required'
        ], [], [
            'mobile' => 'شماره تلفن',
            'IMEI' => 'IMEI'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => '$validator->errors()'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $smsCodeRepo = $this->sms_code_repository;
        try {
            $input = $request->all();
            $finedUser =  $this->user->findOneBy(['mobile' => $input['mobile']]);
            if ($finedUser==null ) {
                $code = $smsCodeRepo->SendValidationCode($input['mobile']);
                $input['password'] = bcrypt($code);
                $input['invite_code'] = $this->user->getInviteCode();
                $this->user->create($input);
                return response()->json([
                    'data' => [
                        'message' => "code sent",
                    ]
                ], 200);
            }else if($this->IMIERepositoryImp->createOrReplaceNewIMIE($finedUser,$input['IMEI'])) {
                $code = $smsCodeRepo->SendValidationCode($input['mobile']);
                $input['password'] = bcrypt($code);
                $input['invite_code'] = $this->user->getInviteCode();
                $finedUser->setPasswordWithCode($code);
                return response()->json([
                    'data' => [
                        'message' => "code sent",
                    ]
                ], 200);
            }else{
                return response()->json([
                    'error' => "Max device login is exceed"
                ], 401);
            }

        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
            'code' => 'required',
        ], [], [
            'mobile' => 'شماره تلفن',
            'code' => 'کد تایید',
        ]);
        if ($validator->fails()) {
            
            return response()->json(['message' => $validator->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
       

        try {
            

            $input = $request->all();
            $credentials['mobile']= $input['mobile'];
            $credentials['password']= $input['code'];

            $user = $this->user->findOneByOrFail(['mobile' => $input['mobile']]);
        
            $token = $this->guard()->attempt($credentials);

            if (!$token) {
          
                return response()->json([
                    'message' => 'کد یا شماره موبایل صحیح نمی باشد.',
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
           
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAuthUser(Request $request)
    {

        $user = JWTAuth::authenticate($request->token);
        $data['user']=$user;
        $data['user']['image'] = $user->image;
        return response()->json($data);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function validationInviteCode(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'invite_code' => 'exists:users,invite_code',
            'fcm_token' => 'required',
            'first_name' => 'string',
            'last_name' => 'string',
        ], [], [
            'invite_code' => 'کد دعوت',
            'fcm_token' => 'کد fcm',
            'first_name' => 'نام',
            'last_name' => 'نام‌خانوادگی',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $user = JWTAuth::authenticate($request->token);
        $input = $request->all();
        if(isset($input['invite_code'])){
            $status = $this->invite->validationCode($input['invite_code'], $user->id);
            if ($status) {
                $user->update([
                    'fcm_token' => $input['fcm_token'],
                    'first_name' => $input['first_name'],
                    'last_name' => $input['last_name'],
                ]);
                return response()->json(['message' => 'کد دعوت برای شما ثبت شد.','user' => $user]);
            } else {
                return response()->json(['message' => 'کد دعوت اشتباه یا تکراری می‌باشد.'], JsonResponse::HTTP_BAD_REQUEST);
            }
        }else{
            $user->update([
                'fcm_token' => $input['fcm_token'],
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
            ]);
            return response()->json($user);
        }
    }

    public function getInvited()
    {
        $user = auth()->user();
        return $this->user->getInvited($user->id);
    }

}
