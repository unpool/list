<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->tickets()->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate([
            'node_id'   => 'required|numeric|exists:nodes,id',
            'title'     => 'required|string',
            'question'  => 'required|string'
        ]);

        $ticket = User::all()->first()->tickets()->create($request->only([
            'title', 'question', 'node_id'
        ]));

        if ($ticket instanceof Ticket) {
            return response()->json(['message' => 'ok']);
        }

        return response()->json(['message' => 'server error'], 502);
    }

    public function destroy(Ticket $ticket)
    {
        if ($ticket->user_id != auth()->user()->id){
            return response()->json(['message' => 'این تییکت مال شما نیست'], 404);
        }
        $ticket->delete();
        return response()->json(['message' => 'ok']);
    }
}
