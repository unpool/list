<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\BestNodeRepositoryImp;
use App\Repositories\NodeRepositoryImp;

class BestNodeController extends Controller
{
    /**
     * @var BestNodeRepositoryImp
     */
    private $bestNodeRepo;

    /**
     * @var NodeRepositoryImp
     */
    private $nodeRepo;

    public function __construct(BestNodeRepositoryImp $bestNodeRepo, NodeRepositoryImp $nodeRepo)
    {
        $this->bestNodeRepo = $bestNodeRepo;
        $this->nodeRepo = $nodeRepo;
    }

    public function index(): \Illuminate\View\View
    {
        return view('admin.node.best.index', [
            'items' => $this->bestNodeRepo->paginate(10, 'id', 'desc', array('node')),
            'root_nodes' => $this->nodeRepo->getRoots()
        ]);
    }

    public function store(\App\Http\Requests\Admin\BestNodeRequest $request)
    {
        \App\Models\BestNode::updateOrCreate(['node_id' => (int) $request->get('category')], []);
        session()->flash('alert', [
            'type' => 'success',
            'message' => 'با موفقیت انجام شد.',
        ]);
        return redirect()->to(route('admin.node.best.index'));
    }
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->bestNodeRepo->delete($id);
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.',
            ]);
        } catch (\Exception $e) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خاطیی رخ داده است.',
            ]);
        }
        return redirect()->to(route('admin.node.best.index'));
    }
}
