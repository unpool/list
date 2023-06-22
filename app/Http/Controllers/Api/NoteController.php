<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Models\Note;
use App\User;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Node $node,Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'min:1']
        ]);

        Note::create([
            'description' => $request->description,
            'user_id'     => auth()->user()->id,
            'node_id'     => $node->id
        ]);

        return response()->json([
            'message' => 'اضافه شدن یادداشت با موفقیت انجام شد'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Node $node)
    {
        $notes = Note::where('user_id', auth()->user()->id)
                        ->where('node_id', $node->id)->get();

        return response()->json([
           "data" => $notes
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id != auth()->user()->id){
            return response()->json([
                'message' => 'این یاد داشت مال شما نیست'
            ]);
        }

        $request->validate([
            'description' => ['required', 'string', 'min:1']
        ]);

        $note->update($request->all());

        return response()->json([
            'message' => 'بروز رسانی با موفقیت انجام شد'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        if ($note->user_id != auth()->user()->id){
            return response()->json([
                'message' => 'این یاد داشت مال شما نیست'
            ]);
        }

        $note->delete();

        return response()->json([
            'message' => 'یاداشت با موفقیت حذف شد',
            'status'  => 200
        ]);
    }
}
