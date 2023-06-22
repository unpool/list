<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SupportRepositoryImp;
use App\Models\Support;
use Illuminate\Pagination\LengthAwarePaginator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;




class SupportController extends Controller
{



    public function paginate(int $limit = 10, string $orderBy = 'id', string $sortType = 'desc', array $with = null): \Illuminate\Pagination\LengthAwarePaginator
    {
        return !is_null($with)
            ? $this->model
                ->orderBy($orderBy, $sortType)
                ->with($with)
                ->paginate($limit)
            : $this->model
                ->orderBy($orderBy, $sortType)
                ->paginate($limit);
    }
    public function index(Request $request)
    {
        if($request['pid'] != ''){
            $pid = 0;
        }else{
            $pid = ($request['pid'] * 20)-1;
        }
        $items = Support::where('parent_id', 0)->orderBy('id','DESC')->offset($pid)->limit(20)->get();
        //$pagein = $this->supRepo->paginate();
        return view('admin.support.index', compact('items'));
    }

    public function edit($id, Request $request){
        $items = Support::where('id', $id)->first();
        $chat_list = Support::where('parent_id',$id)->orderBy('id','DESC')->get();
        Support::where('id',$id)->orWhere(function($q) use ($id){ $q->where('parent_id', $id)->where('type', 'user'); })->update(['seen' => 0]);
        return view('admin.support.edit', compact('items','chat_list'));
    }

    public function update($id, Request $request){
        Support::create([
            'user_id' => 0,
            'type' => 'admin',
            'seen' => 1,
            'parent_id' => $id,
            'message' => $request['message']
        ]);
        setSuccessAlertSession();
        return redirect('admin/support/'. $id .'/edit');
    }

    public function destroy($id, Request $request){
        Support::where('id',$id)->delete();
        Support::where('parent_id',$id)->delete();
        setSuccessAlertSession();
        return redirect(
            route('admin.support.index')
        );
    }





}