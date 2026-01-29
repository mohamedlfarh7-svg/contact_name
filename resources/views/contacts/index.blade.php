<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4 md:p-10">

    <div class="max-w-5xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8 text-center">My Contacts</h1>

        <div class="bg-white p-6 rounded-xl shadow-sm mb-8 border border-gray-200">
            <h2 class="text-lg font-bold mb-4 text-gray-700 border-b pb-2">
                {{ isset($contact) ? 'Edit Contact' : 'Add New Contact' }}
            </h2>
            
            <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}" method="POST">
                @csrf
                @if(isset($contact)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="text" name="first_name" value="{{ old('first_name', $contact->first_name ?? '') }}" placeholder="First Name" class="border p-2 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                    <input type="text" name="last_name" value="{{ old('last_name', $contact->last_name ?? '') }}" placeholder="Last Name" class="border p-2 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                    <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}" placeholder="Email Address" class="border p-2 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                    <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}" placeholder="Phone Number" class="border p-2 rounded-lg outline-none focus:ring-2 focus:ring-blue-400" required>
                    
                    <select name="group_id" class="border p-2 rounded-lg bg-white outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Select Group --</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}" {{ (old('group_id', $contact->group_id ?? '') == $g->id) ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>

                    <div class="flex gap-2">
                        <button type="submit" class="{{ isset($contact) ? 'bg-blue-600' : 'bg-green-600' }} text-white font-bold py-2 px-4 rounded-lg flex-1 transition hover:opacity-90">
                            {{ isset($contact) ? 'Update' : 'Save' }}
                        </button>
                        @if(isset($contact))
                            <a href="{{ route('contacts.index') }}" class="bg-gray-400 text-white py-2 px-4 rounded-lg text-center">Cancel</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-6 text-center shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded-xl shadow-sm mb-6 border border-gray-200">
            <form action="{{ route('contacts.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="flex-1 border border-gray-300 p-2 rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                <select name="group_id" class="w-48 border border-gray-300 p-2 rounded-lg bg-white outline-none">
                    <option value="">All Groups</option>
                    @foreach($groups as $g)
                        <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-blue-700">Filter</button>
                @if(request()->anyFilled(['search', 'group_id']))
                    <a href="{{ route('contacts.index') }}" class="text-red-500 text-sm hover:underline">Clear Filters</a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b text-gray-600 text-xs font-semibold uppercase">
                    <tr>
                        <th class="py-4 px-6">Full Name</th>
                        <th class="py-4 px-6">Contact Info</th>
                        <th class="py-4 px-6">Group</th>
                        <th class="py-4 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $c)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="py-4 px-6 font-bold text-gray-800">{{ $c->first_name }} {{ $c->last_name }}</td>
                            <td class="py-4 px-6 text-sm">
                                <div class="text-gray-600">{{ $c->email }}</div>
                                <div class="text-gray-400 font-mono">{{ $c->phone }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-blue-100 text-blue-700 text-[10px] px-3 py-1 rounded-full font-bold uppercase">
                                    {{ $c->group->name ?? 'None' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center flex justify-center gap-3">
                                <a href="{{ route('contacts.edit', $c->id) }}" class="text-blue-500 font-bold text-sm hover:text-blue-700">Edit</a>
                                <form action="{{ route('contacts.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 italic">No contacts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>