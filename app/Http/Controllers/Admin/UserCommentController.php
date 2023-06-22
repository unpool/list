<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserComment;

class UserCommentController extends Controller
{
    public function index()
    {
       $comments = UserComment::all();
       return view('admin.usercommnet.index',compact('comments'));
    }

    public function create()
    {
        return view('admin.usercommnet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'body'        => 'required',
            'file'        => 'required',
         ]);

        $extention = $request->file->getClientOriginalExtension();

        $file = $request->file('file');
        $originalName = $request->file('file')->getClientOriginalName();
        $imageNmae = time().$originalName;
        $path = '/upload/comment/'.$imageNmae;
        $file->storeAs('public/upload/comment/',$imageNmae);


        $res = UserComment::create([
            'title' => $request->title,
            'body'  => $request->body,
            'file' => $path,
            'file_type' => $extention
        ]);

        if ($res) {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.'
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.'
            ]);
        }

        $res->save();

       return redirect(route('admin.user_comment.index'));
    }

    public function edit($id)
    {
        $comment = UserComment::findOrFail($id);
        return view('admin.usercommnet.edit',compact('comment'));
    }

    public function update(Request $request , $id)
    {
        $comment = UserComment::find($id);
        //dd($request->file);
        if($request->hasFile('file'))
         {
            //dd($request->file);
            unlink('storage'.$comment->file);

            $file = $request->file('file');
            $originalName = $request->file('file')->getClientOriginalName();
            $imageNmae = time().$originalName;
            $path = '/upload/comment/'.$imageNmae;
            $file->storeAs('public/upload/comment/',$imageNmae);

            $extention = $request->file->getClientOriginalExtension();

            $res = $comment->update([
                'title' => $request->title,
                'body' => $request->body,
                'file' => $path,
                'file_type' => $extention
            ]);

            if ($res) {
                session()->flash('alert', [
                    'type' => 'success',
                    'message' => 'با موفقیت انجام شد.'
                ]);
            } else {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'متاسفانه خطایی رخ داده است.'
                ]);
            }
         }
         else {
            $res = $comment->update($request->all());
            if ($res) {
                session()->flash('alert', [
                    'type' => 'success',
                    'message' => 'با موفقیت انجام شد.'
                ]);
            } else {
                session()->flash('alert', [
                    'type' => 'danger',
                    'message' => 'متاسفانه خطایی رخ داده است.'
                ]);
            }
         }


         return redirect(route('admin.user_comment.index'));
    }

    public function delete($id)
    {
        $comment = UserComment::findOrFail($id);
        $res = $comment->delete();

        if ($res) {
            session()->flash('alert', [
                'type' => 'success',
                'message' => 'با موفقیت انجام شد.'
            ]);
        } else {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => 'متاسفانه خطایی رخ داده است.'
            ]);
        }
        return redirect(route('admin.user_comment.index'));
    }
}
