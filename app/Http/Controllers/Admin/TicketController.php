<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function ticketsWithoutAnswer()
    {
        $tickets = Ticket::with(['user', 'admin', 'node'])->whereNull('answer')->get();
        return view('admin.ticket.index')->with('tickets', $tickets);
    }

    public function Answer(Ticket $ticket)
    {
        return view('admin.ticket.answer')->with('ticket', $ticket);
    }

    public function Answered()
    {
        $tickets = Ticket::with(['user', 'admin', 'node'])->whereNotNull('answer')->get();
        return view('admin.ticket.index')->with('tickets', $tickets);
    }

    public function answerToQuestion(Request $request, Ticket $ticket)
    {
        $request->validate([
            'answer' => 'required|string'
        ]);

        $result = $ticket->answerToQuestion($request->input('answer'));

        if ($result) {
            return redirect()->back();
        }
    }
}
