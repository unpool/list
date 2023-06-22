<?php

namespace App\Http\Controllers\Api;

use App\Models\GroupConversation;
use App\Repositories\ConversationRepository;
use DB;
use Exception;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;

/**
 * Class ConversationController
 * @package App\Http\Controllers\Api
 */
class ConversationController extends Controller
{
    /**
     * @var int
     */
    private $per_page = 10;

    /**
     * @var ConversationRepository
     */
    protected $conversation;

    /**
     * ConversationController constructor.
     * @param ConversationRepository $conversation
     */
    public function __construct(ConversationRepository $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Request $request)
    {
        $conversation = $this->conversation;
        $validate = Validator::make($request->all(), [
            'text' => 'required',
            'reply_id' => 'numeric',
            'node_id' => 'required|exists:nodes,id',
            'is_public' => 'required',
        ], [], [
            'text' => 'متن',
            'node_id' => 'پکیج',
            'is_public' => 'عمومی یا خصوصی',
        ]);
        if ($validate->fails()) {
            return response()->json([$validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $input = $request->all();
        $user = JWTAuth::authenticate($request->token);
        $input['conversationable_id'] = $user->id;
        $input['conversationable_type'] = User::class;
        $input['user_id'] = $user->id;
        return response()->json($this->conversation->create($input));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function publicConversations(Request $request)
    {
        $group_conversation = $this->conversation->group_conversation;
        $validate = Validator::make($request->all(), [
            'node_id' => 'required|exists:nodes,id',
        ], [], [
            'node_id' => 'پکیج',
        ]);
        if ($validate->fails()) {
            return response()->json([$validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $group = $group_conversation::where(['node_id' => $request->get('node_id'), 'is_public' => 1])->first();
        $conversations = array();
        if (!empty($group)) {
            $conversations = $group->conversations()->paginate();
        }
        return response()->json($conversations);
    }

    public function privateConversation(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'node_id' => 'required|exists:nodes,id',
            'page' => 'required',
        ], [], [
            'node_id' => 'پکیج',
            'page' => 'صفحه',
        ]);
        if ($validate->fails()) {
            return response()->json([$validate->errors()], JsonResponse::HTTP_BAD_REQUEST);
        }
        $private_conversation = array();
        $input = $request->all();
        $user = JWTAuth::authenticate($request->token);
        $page = ($request->get('page') - 1) * $this->per_page;
        $group_conversation = $this->conversation->group_conversation::whereHas('conversations', function ($query) use ($user) {
            $query->where('conversationable_type', '=', User::class);
            $query->where('conversationable_id', '=', $user->id);
        })->where(['node_id' => $input['node_id'], 'is_public' => 0])->first();
        if (!empty($group_conversation)) {
            $private_conversation = $group_conversation->conversations()->orderBy('id', 'desc')->offset($page)->limit($this->per_page)->get();
        }
        return response()->json($private_conversation);
    }
}
