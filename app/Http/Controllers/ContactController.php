<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Group;

class ContactController extends Controller
{

    public function index(Request $request){
        $query = Contact::with('group');
        if($request->filled('search')){
            $search = $request->search;
            $query->where('first_name','like',"%{$search}%")->orWhere('last_name','like',"%{$search}%");
        }

        if($request->filled('group_id')){
            $query->where('group_id',$request->group_id);
        }

        $contacts = $query->get();
        $groups = Group::all();
        return view('contacts.index',compact('contacts','groups'));


    }

    public function destroy($id){
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->back()->with('success', 'Contact deleted');
    }

    public function edit($id){
        $contact = Contact::findOrFail($id);
        $groups = Group::all();
        $contacts = Contact::with('group')->get();
        return view('contacts.index', compact('contact', 'groups', 'contacts'));
    }

    public function update(Request $request , $id){
        $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|max:255',
        'phone'      => 'required|string|min:10',
        'group_id'   => 'required|exists:groups,id',
         ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact updated!');
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
