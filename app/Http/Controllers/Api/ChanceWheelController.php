<?php

namespace App\Http\Controllers\Api;

use App\Models\ChanceWheel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChanceWheelController extends Controller
{
    public function index()
    {
        $wheels = ChanceWheel::all();

        return response()->json([
            'data' => $wheels
        ]);
    }

    public function wheeling(Request $request)
    {
        $request->validate([
            'wheel' => 'required|numeric|exist:chance-wheels,id'
        ]);

        if (auth()->user()->chance_wheeled_at->diffInHours(now()) < 24) {
            return response()->json([
                'message' => 'هر روز فقط یکبار می توانید سعی کنید!'
            ]);
        }

        $result = auth()->user()->update([
            'score' => auth()->user()->score + $request->input('wheel'),
            'chance_wheeled_at' => now()
        ]);

        if ($result) {
            return response()->json([
                'message' => 'ok'
            ]);
        }
    }
}
