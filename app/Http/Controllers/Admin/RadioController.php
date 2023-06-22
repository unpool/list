<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Radio;
use Storage;

class RadioController extends Controller
{

     public function index()
     {
        $radioes = Radio::all();
        return view('admin.radio.index' , compact('radioes'));
     }

     /**
      * create a radio
      *
      * @return void
      */
     public function create()
     {
        return view('admin.radio.create');
     }

     public function store(Request $request)
     {
         $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'file'        => 'required',
         ]);

            $file = $request->file('file');
            $originalName = $request->file('file')->getClientOriginalName();
            $imageNmae = time().$originalName;
            $path = '/upload/radio/'.$imageNmae;
            $file->storeAs('public/upload/radio/',$imageNmae);


        //dd($path);

        auth_admin()->loginUsingId(1);
        //dd(auth_admin()->user()->id);
        $res = Radio::create([
            'title' => $request->title,
            'admin_id' => auth_admin()->user()->id,
            'description' => $request->description,
            'file'        => $path,
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

       return redirect(route('admin.radio.index'));
     }

     public function edit($id)
     {
         $radio = Radio::find($id);
        return view('admin.radio.edit',compact('radio'));
     }

     public function update($id , Request $request)
     {
         $radio = Radio::find($id);



         if($request->hasFile('file'))
         {
           // dd($radio->file);
            //unlink('storage'.$radio->file);

            $file = $request->file('file');
            $originalName = $request->file('file')->getClientOriginalName();
            $imageNmae = time().$originalName;
            $path = '/upload/radio/'.$imageNmae;
            $file->storeAs('public/upload/radio/',$imageNmae);

            $res = $radio->update([
                'title' => $request->title,
                'description' => $request->description,
                'file' => $path,
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
            $res = $radio->update($request->all());
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


         return redirect(route('admin.radio.index'));
     }

     public function delete($id)
     {
        $radio = Radio::find($id);
        $res = $radio->delete();

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
        return redirect(route('admin.radio.index'));
     }


}
