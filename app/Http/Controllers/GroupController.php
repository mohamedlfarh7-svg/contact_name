<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:groups,name']);
        Group::create($request->all());
        return redirect()->back()->with('success', 'Group created!');
    }

    public function edit($id)
    {
        $group = Group::findOrFail($id);
        $groups = Group::all();
        return view('groups.index', compact('group', 'groups'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $group = Group::findOrFail($id);
        $group->update($request->all());
        return redirect()->route('groups.index')->with('success', 'Group updated!');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->contacts()->delete(); 
        $group->delete();
        return redirect()->back()->with('success', 'Group and its contacts deleted!');
    }
}