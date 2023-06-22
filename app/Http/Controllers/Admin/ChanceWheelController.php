<?php

namespace App\Http\Controllers\Admin;

use App\Models\ChanceWheel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChanceWheelController extends Controller
{
    public function index()
    {
        $wheels = ChanceWheel::with('admin')->get();
        return view('admin.chance-wheel.index')->with('wheels', $wheels);
    }

    public function create()
    {
        return view('admin.chance-wheel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'score' => 'required|numeric'
        ]);

        $wheel = ChanceWheel::create([
            'admin_id'  => auth_admin()->user()->id,
            'name'      => $request->input('name'),
            'score'     => $request->input('score')
        ]);

        if ($wheel instanceof ChanceWheel) {
            $wheels = ChanceWheel::with('admin')->get();
            return view('admin.chance-wheel.index')->with('wheels', $wheels);
        }

        // error handle
    }

    public function edit(ChanceWheel $wheel)
    {
        return view('admin.chance-wheel.edit')->with('wheel', $wheel);
    }

    public function update(Request $request, ChanceWheel $wheel)
    {
        $wheel->update([
            'name'      => $request->input('name'),
            'score'     => $request->input('score')
        ]);
        return redirect()->back()->with('wheel', $wheel);
    }

    public function destroy(ChanceWheel $wheel)
    {
        $wheel->delete();

        return redirect()->back();
    }
}
