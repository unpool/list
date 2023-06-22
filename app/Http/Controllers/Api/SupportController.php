<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;



class SupportController extends Controller
{
    public function support_list(){
        $user = auth()->user();
        try {
            return response()->json(Support::where('parent_id', 0)->where('user_id',$user->id)->get());
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function support_view(Request $request){
        $user = auth()->user();
        $check = Support::where('user_id', $user->id)->where('id', $request['id'])->count();
        if($check > 0){
            Support::where('parent_id',$request['id'])->where('type', 'admin')->update(['seen' => 0]);
            return response()->json(Support::where('parent_id', $request['id'])->orWhere('id', $request['id'])->orderBy('id', 'DESC')->get());
        }else{
            return response()->json(['message' => 'support not for you'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function support_add(Request $request){
        $user = auth()->user();
        if($request['message'] == ''){
            return response()->json(['message' => 'message not null'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }else{
            if($request['id'] == ''){
                if($request['title'] == ''){
                    return response()->json(['message' => 'title not null'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
                }
                Support::create([
                    'user_id' => $user->id,
                    'parent_id' => 0,
                    'type' => 'user',
                    'seen' => 1,
                    'title' => $request['title'],
                    'message' => $request['message']
                ]);
                return response()->json('', 200);
            }else{
                Support::create([
                    'user_id' => $user->id,
                    'parent_id' => $request['id'],
                    'type' => 'user',
                    'seen' => 1,
                    'title' => $request['title'],
                    'message' => $request['message']
                ]);
                return response()->json('', 200);
            }
        }

    }
}