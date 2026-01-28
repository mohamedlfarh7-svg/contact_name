<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Group;

class ContactController extends Controller
{

    public function index(Request $request){
        $contacts = \App\Models\Contact::with('group')->get();
        $groups = \App\Models\Group::all();
        return view('contacts.index',compact('contacts','groups'));


    }

    public function store(Request $request){
        $request -> validate([
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'group_id'=> 'required|exists:groups,id',
            'phone'=>'required|string|min:10',

        ]);
        \App\Models\Contact::create($request->all());
        return redirect()->back()->with('success', 'Contact added successfully!');
    }

}
