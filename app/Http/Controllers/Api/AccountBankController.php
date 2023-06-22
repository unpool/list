<?php

namespace App\Http\Controllers\Api;

use App\Models\AccountBank;
use App\Repositories\AccountBankRepository;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Http\JsonResponse;
use Validator;


class AccountBankController extends Controller
{

    public $account;

    /**
     * @param AccountBankRepository $account
     */
    public function __construct(AccountBankRepository $account)
    {
        $this->account = $account;
    }

    public function create(Request $request)
    {
        $account = $this->account;
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'account_number' => 'required'
        ], [], [
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'account_number' => 'شماره حساب',
        ]);
        $input = $request->all();
        $user = auth()->user();
        $input['user_id'] = $user->id;
        if ($validator->fails()) {
            return response()->json($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        try {
            return response()->json($account->create($input));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


    public function index()
    {
        $user = auth()->user();
        return response()->json($this->account->findOneBy(['user_id' => $user->id]));
    }

    public function delete(Request $request)
    {
        $account = $this->account;
        $validator = Validator::make($request->all(), [
            'account_number_id' => 'required',
        ], [], [
            'account_number_id' => 'شماره حساب',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        try {
            $account->delete($request->get('account_number_id'));
            return response()->json(['message' => 'حساب کاربری با موفقیت حذف شد.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

}
