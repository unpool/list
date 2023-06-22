<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PriceType;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\OrderRepository;
use App\Repositories\PriceRepository;
use App\Repositories\UserRepositoryImp;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Node;
use App\Http\Requests\Admin\OrderRequest;

class OrderController extends Controller
{

    private $order_repo;
    private $user_repo;
    private $node_repo;
    private $price_repo;

    public function __construct(OrderRepository $order, UserRepositoryImp $user_repo, NodeRepositoryImp
    $node_repo,PriceRepository $price)
    {
        $this->order_repo = $order;
        $this->user_repo = $user_repo;
        $this->node_repo = $node_repo;
        $this->price_repo = $price;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $orders = $this->order_repo->paginate();
        return view('admin.order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $users = $this->user_repo->all();
        $nodes = $this->node_repo->all();
        return view('admin.order.create', ['users' => $users, 'nodes' => $nodes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return RedirectResponse
     */
    public function store(OrderRequest $request)
    {
        $input = $request->all();
        $input['is_paid'] = 1;
        $nodes=[];
        foreach ($input['nodes'] as $node_id){
            $nod['send_type']=$input['send_type'];
            array_push($nodes, ['send_type'=>$input['send_type'],'node_id'=>$node_id]);

        }
        $input['nodes']=$nodes;
        $this->order_repo->create($input);
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->route('admin.order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $order = $this->order_repo->findOneOrFail($id);
        return view('admin.order.show', ['order' => $order]);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $order = $this->order_repo->findOneOrFail($id);
        $user = $order->user;
        $product_ids = $order->orderables()->where('nodeable_type',Node::class)->pluck('nodeable_id')->toArray();
        if($order->delete() && !empty($product_ids) && $order->is_paid){
            $share = $this->price_repo->getShare($product_ids);
            $user->share -=$share;
            $user->save();
        }
        return back();
    }
}
