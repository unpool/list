<?php

namespace App\Http\Controllers\Api;

use App\Repositories\PlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    private $plan_repo;
    public function __construct(PlanRepository $plan)
    {
        $this->plan_repo = $plan;
    }

    public function index()
    {
        return response()->json($this->plan_repo->all());
    }
}
