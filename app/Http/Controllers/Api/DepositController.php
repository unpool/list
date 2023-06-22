<?php

namespace App\Http\Controllers\Api;

use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function getDepositRequests()
    {
        $deposit_requests = Deposit::with('admin')->get();

        return response()->json([
            'message'   => 'ok',
            'data'      => $deposit_requests->toArray(),
        ]);
    }

    public function depositRequest(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'price'         => 'required|numberic|min:1000|max:' . auth()->user()->share,
            'card_number'   => 'required|numberic|digits:16',
        ]);

        if($validation->fails()){
            return response()->json([
                'message'   => $validation->messages(),
            ]);
        }

        auth()->user()->deposits()->create([
            'price' => $request->input('price'),
            'card_number' => $request->input('card_number'),
        ]);

        return response()->json([
            'message'   => 'ok',
        ]);
    }
}
