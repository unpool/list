<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CheckoutRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    private $checkout_repo;

    public function __construct(CheckoutRepository $checkout)
    {
        $this->checkout_repo = $checkout;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'type' => 'required',
        ], [], [
            'value' => 'مقدار',
            'type' => 'نوع',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $input = $request->all();
            if($user->share < $input['value']){
                return response()->json(['value' => ['مقدار وارد شده بیشتر از مقدار مجاز می‌باشد.']], JsonResponse::HTTP_BAD_REQUEST);
            }
            $input['user_id'] = $user->id;
            $checkout = $this->checkout_repo->create($input);
            $checkout->chargeWallet();
            DB::commit();
            return response()->json(['message' => 'درخواست شما با موفقیت ثبت شد.']);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([$e->getMessage()],JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function index()
    {
        $user = auth()->user();
        return response()->json($this->checkout_repo->getIndexByUserId($user->id));
    }

}
