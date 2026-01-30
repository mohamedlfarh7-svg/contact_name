<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with('group');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        $contacts = $query->get();
        $groups = Group::all();

        return view('contacts.index', compact('contacts', 'groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|min:10',
            'group_id'   => 'required|exists:groups,id',
            'image'      => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contacts', 'public');
        }

        Contact::create($data);

        return redirect()->route('contacts.index')->with('success', 'Contact added successfully!');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $groups = Group::all();
        $contacts = Contact::with('group')->get();

        return view('contacts.index', compact('contact', 'groups', 'contacts'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|min:10',
            'group_id'   => 'required|exists:groups,id',
            'image'      => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($contact->image) {
                Storage::disk('public')->delete($contact->image);
            }
            $data['image'] = $request->file('image')->store('contacts', 'public');
        }

        $contact->update($data);

        return redirect()->route('contacts.index')->with('success', 'Contact updated!');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->image) {
            Storage::disk('public')->delete($contact->image);
        }

        $contact->delete();

        return redirect()->back()->with('success', 'Contact deleted');
    }
}