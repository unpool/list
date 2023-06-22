<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PlanRequest;
use App\Repositories\NodeRepositoryImp;
use App\Repositories\PlanRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PlanController extends Controller
{
    private $plan_repo;
    private $nodeRepo;

    public function __construct(PlanRepository $plan,NodeRepositoryImp $nodeRepo)
    {
        $this->plan_repo = $plan;
        $this->nodeRepo = $nodeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.plan.index', [
            'plans' => $this->plan_repo->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.plan.create', [
            'root_nodes' => $this->nodeRepo->getRoots()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanRequest $request
     * @return RedirectResponse
     */
    public function store(PlanRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['score'] = convert_to_english_digit($input['score']);
        $input['period'] = convert_to_english_digit($input['period']);
        $input['price'] = convert_to_english_digit($input['price']);
        $input['share_invited'] = convert_to_english_digit($input['share_invited']);
        $input['category'] = convert_to_english_digit($input['category']);
        $this->plan_repo->create($input);
        return redirect()->route('admin.plan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $plan = $this->plan_repo->findOneOrFail($id);
        return view('admin.plan.edit',['root_nodes' => $this->nodeRepo->getRoots()])->with('plan',$plan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PlanRequest $request, $id): RedirectResponse
    {
        $plan = $this->plan_repo->findOneOrFail($id);
        $input = $request->all();
        if(!isset($input['is_special'])){
            $input['is_special'] = 0;
        }
        $input['score'] = convert_to_english_digit($input['score']);
        $input['period'] = convert_to_english_digit($input['period']);
        $input['price'] = convert_to_english_digit($input['price']);
        $input['share_invited'] = convert_to_english_digit($input['share_invited']);
        $input['category'] = convert_to_english_digit($input['category']);
        $plan->update($input);
        return redirect()->route('admin.plan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->plan_repo->delete($id);
        return redirect()->route('admin.plan.index');

    }
}
