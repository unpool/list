<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\CheckoutRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{

    private $checkout_repo;

    public function __construct(CheckoutRepository $checkout)
    {
        $this->checkout_repo = $checkout;
    }

    public function index()
    {
        return view('admin.checkout.index',[
            'items' => $this->checkout_repo->paginate()
        ]);
    }

    public function status(int $checkout_id)
    {
        $checkout = $this->checkout_repo->findOneOrFail($checkout_id);
        $checkout->status = !$checkout->status;
        $checkout->update();
        return back();
    }

}
