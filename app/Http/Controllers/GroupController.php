<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(){
    $groups = \App\Models\Group::all();
    return view('groups.index', compact('groups'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\Group::create($request->all());

        return redirect()->back()->with('success', 'Group added successfully!');
    }
}
