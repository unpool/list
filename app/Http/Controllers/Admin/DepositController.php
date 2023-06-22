<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function index()
    {
        $deposit_requests = Deposit::with('user', 'admin')->get();

        return view('admin.payment.deposits')->with('deposit_requests', $deposit_requests);
    }

    public function payed(Deposit $deposit)
    {
        $deposit->update([
            'status' => '1',
        ]);

        $deposit_requests = Deposit::with('user', 'admin')->get();

        return redirect()->back()->with('deposit_requests', $deposit_requests);
    }

    public function rejected(Deposit $deposit)
    {
        $deposit->update([
            'status' => '0',
        ]);

        $deposit_requests = Deposit::with('user', 'admin')->get();

        return redirect()->back()->with('deposit_requests', $deposit_requests);
    }
}
