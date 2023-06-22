<?php

namespace App\Http\Controllers\Api;

use App\Enums\MediaType;
use App\Http\Requests\Api\UserRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Validator;

class UserController extends Controller
{
    public $user;
    private $per_page = 10;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function update(UserRequest $request)
    {
        $user = JWTAuth::authenticate($request->get('token'));
        $input = $request->all();
        $image_input = array();
        if (!empty($input['password']) && isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }
        if (!empty($input['birth_date'])) {
            $input['birth_date'] = JtoG($input['birth_date'], '-');
        }
        if (!empty($input['image']) && isset($input['image'])) {
            $size = getimagesize($input['image']);
            $image_input['size'] = $size[0] . "x" . $size[1];
            $image_input['path'] = uploadFile($input['image']);
            if (!empty($user->image()->count())) {
                removeMediaFromDirectory($user->image()->first()->path);
                $user->image()->update($image_input);
            } else {
                $user->image()->create($image_input, ['type' => MediaType::IMAGE]);
            }
        }
        try {
            if($user->email != null && !empty($request['email'])){
                $user->score = 1;
            }

            $user['image'] = $user->image()->first();
            $user->update($input);

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function setImei(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'imei' => 'required|string',
        ], [], [
            'imei' => 'کد IMEI',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $user = JWTAuth::authenticate($request->get('token'));
        $this->user->user_imei->create([
            'user_id' => $user->id,
            'imie' => $request->get('imei')
        ]);
        return response()->json([$user->imie], JsonResponse::HTTP_ACCEPTED);
    }

    public function yourAccount()
    {
        $user = auth()->user();
        $data['invite_code'] = $user->invite_code;
        $data['score'] = $user->score;
        $data['share'] = $user->share;
        $data['invited'] = $user->invites()->count();
        return response()->json($data);
    }

    public function getUsersByScore()
    {
        $user = auth()->user()->toArray();
        $users = $this->user->getUsersByScore();
        return response()->json(['users' => $users,'position' => array_search($user,$users) + 1]);
    }
}
