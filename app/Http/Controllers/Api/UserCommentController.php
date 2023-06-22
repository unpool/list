<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserComment;

class UserCommentController extends Controller
{
    public function index()
    {
        $comments = UserComment::all();

        return response()->json([
            'data' => $comments,
            'status' => 200
        ]);
    }
}
