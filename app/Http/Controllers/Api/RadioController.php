<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Radio;
use App\Models\UserComment;

class RadioController extends Controller
{
   public function index(Request $request)
   {
    $radios = UserComment::whereBetween('created_at', [$request->get('start'), $request->get('end')])
    ->get();

    return response()->json([
        'data' => $radios,
        'status' => 200
    ]);
   }

   public function single(Radio $radio)
   {
        return response()->json([
            'data' => $radio,
            'status' => 200

        ]);
   }
}
