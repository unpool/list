<?php

namespace App\Http\Controllers\Api;

use App\Models\BestNode;
use App\Models\Node;
use App\Models\Slider;
use App\Repositories\BestNodeRepository;
use App\Repositories\NodeRepository;
use App\Repositories\SliderRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class NodeController extends Controller
{
    private $node;
    private $best_node;
    private $per_page = 10;

    public function __construct(NodeRepository $node,BestNodeRepository $best_node)
    {
        $this->node = $node;
        $this->best_node = $best_node;
    }

    public function packages()
    {
        $packages = $this->node->getPaginatedPublishPackages('10','id','desc',['ownerable.teacher','images','voices','videos', 'prices','pdfs','offices']);
        return response()->json($packages);
    }

    public function getRoots()
    {
        return $this->node->getPaginateRoots();
    }

    public function getPackage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'node_id' => 'required|numeric',
            'user_id' => 'nullable|numeric'
        ], [], [
            'node_id' => 'پکیج'
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $user_id = $request->get('user_id');
        $node = $this->node->getNodeWithSeparateMedias($request->get('node_id'));
        if ($node==null)
            return response()->json(['message'=> 'node not fund'],404);
        $children="";
        $children = $node->where('parent_id',$node->id)->where('status','publish')->with(['images', 'voices', 'videos', 'prices','pdfs','offices'])->get();

        $is_owner = false;
        if($user_id){
            $is_owner = $this->node->checkNodeBoughtUser($node->id,$user_id);
        }
        return response()->json(array($node, $children,['is_owner' => $is_owner]));
    }

    public function getProduct(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'node_id' => 'required|numeric',
            'user_id' => 'nullable|numeric'
        ], [], [
            'node_id' => 'پکیج'
        ]);
        $user_id = $request->get('user_id');
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $is_owner = false;
        $node = $this->node->getNodeWithSeparateMedias($request->get('node_id'));
        if($user_id){
            $is_owner = $this->node->checkNodeBoughtUser($node->id,$user_id);
        }
        return response()->json([$node,['is_owner' => $is_owner]]);
    }

    public function getSliders()
    {
        return response()->json(Slider::with(['node','images','videos'])->orderBy('sliders.id', 'desc')->get());
    }

    public function getBestPackage()
    {
        $nodes = $this->best_node->getBestNodeOrderDesc();
        return response()->json($nodes);
    }
}
