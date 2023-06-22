<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var $order OrderRepository
     */
    public $order;

    /**
     * @param $order
     */
    public function __construct(OrderRepository $order)
    {
        $this->order = $order;
    }

    public function checkPayment(Request $request){

        $data = $request->all();
        if ($data['Status'] == "OK") {
            try {
                DB::beginTransaction();
                $order = Order::findOrFail($request->get('order_id'));
                if ($order->is_paid==0) {
                    $order->update([
                        'is_paid' => 1
                    ]);
                    $this->order->calculateAndAddSource($order);
                }
                DB::commit();
            }catch (\Exception $e){
                return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        return view('check-payment', compact('data'));
    }

    public function checkWallet(Request $request)
    {
        $data = $request->all();
        if ($data['Status'] == "OK") {
            try {
                DB::beginTransaction();
                $order = Order::findOrFail($request->get('order_id'));
                if ($order->is_paid==0) {
                    $order->update([
                        'is_paid' => 1
                    ]);
                    $this->order->calculateAndAddSource($order);
                }
                DB::commit();
            }catch (\Exception $e){
                return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
        return view('check-payment', compact('data'));
    }
}
