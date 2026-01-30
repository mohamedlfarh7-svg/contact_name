<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management | Dark Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1120; }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4f46e5; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-300 antialiased p-4 md:p-10">

    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <h1 class="text-4xl font-black text-white tracking-tight">My <span class="text-indigo-500">Network</span></h1>
                <p class="text-slate-500 font-medium mt-1">Manage your professional and personal connections.</p>
            </div>
            <a href="{{ route('groups.index') }}" class="group flex items-center gap-2 bg-slate-900 border border-slate-700 px-6 py-3 rounded-2xl text-sm font-bold text-slate-300 hover:bg-slate-800 hover:text-white transition-all shadow-xl">
                Manage Groups
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl mb-10">
            <h2 class="text-xl font-bold mb-6 text-white flex items-center gap-2">
                <span class="w-1.5 h-5 bg-indigo-500 rounded-full"></span>
                {{ isset($contact) ? 'Update Contact' : 'Create New Entry' }}
            </h2>
            
            <form action="{{ isset($contact) ? route('contacts.update', $contact->id) : route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($contact)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="md:col-span-1">
                        <input type="text" name="first_name" value="{{ old('first_name', $contact->first_name ?? '') }}" placeholder="First Name" class="w-full bg-slate-950 border border-slate-800 p-3.5 rounded-xl outline-none focus:border-indigo-500 text-white placeholder:text-slate-700 transition" required>
                    </div>
                    <div class="md:col-span-1">
                        <input type="text" name="last_name" value="{{ old('last_name', $contact->last_name ?? '') }}" placeholder="Last Name" class="w-full bg-slate-950 border border-slate-800 p-3.5 rounded-xl outline-none focus:border-indigo-500 text-white placeholder:text-slate-700 transition" required>
                    </div>
                    <div class="md:col-span-1">
                        <input type="email" name="email" value="{{ old('email', $contact->email ?? '') }}" placeholder="Email Address" class="w-full bg-slate-950 border border-slate-800 p-3.5 rounded-xl outline-none focus:border-indigo-500 text-white placeholder:text-slate-700 transition" required>
                    </div>
                    <div class="md:col-span-1">
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone ?? '') }}" placeholder="Phone Number" class="w-full bg-slate-950 border border-slate-800 p-3.5 rounded-xl outline-none focus:border-indigo-500 text-white placeholder:text-slate-700 transition" required>
                    </div>
                    
                    <div class="md:col-span-1">
                        <select name="group_id" class="w-full bg-slate-950 border border-slate-800 p-3.5 rounded-xl outline-none focus:border-indigo-500 text-slate-400 transition" required>
                            <option value="">-- Select Group --</option>
                            @foreach($groups as $g)
                                <option value="{{ $g->id }}" {{ (old('group_id', $contact->group_id ?? '') == $g->id) ? 'selected' : '' }}>
                                    {{ $g->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <input type="file" name="image" class="w-full bg-slate-950 border border-slate-800 p-2.5 rounded-xl text-sm text-slate-500 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-indigo-500/10 file:text-indigo-400 hover:file:bg-indigo-500/20 transition cursor-pointer">
                    </div>

                    <div class="md:col-span-1 flex gap-2">
                        <button type="submit" class="flex-1 {{ isset($contact) ? 'bg-indigo-600' : 'bg-emerald-600' }} text-white font-black py-3 rounded-xl shadow-lg transition hover:scale-[1.02] active:scale-95">
                            {{ isset($contact) ? 'Update' : 'Save' }}
                        </button>
                        @if(isset($contact))
                            <a href="{{ route('contacts.index') }}" class="bg-slate-800 text-slate-400 py-3 px-4 rounded-xl text-center font-bold hover:text-white transition">✕</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 p-4 rounded-2xl mb-8 flex items-center gap-3 animate-pulse">
                <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-slate-900 border border-slate-800 p-5 rounded-3xl mb-8">
            <form action="{{ route('contacts.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-4 items-center">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search connections..." class="w-full bg-slate-950 border border-slate-800 p-3 pl-10 rounded-2xl outline-none focus:border-indigo-500 text-white placeholder:text-slate-700 transition">
                    <svg class="w-4 h-4 absolute left-3 top-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <select name="group_id" class="w-full md:w-48 bg-slate-950 border border-slate-800 p-3 rounded-2xl outline-none text-slate-500">
                    <option value="">All Groups</option>
                    @foreach($groups as $g)
                        <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full md:w-auto bg-slate-800 text-white px-8 py-3 rounded-2xl font-bold hover:bg-indigo-600 transition shadow-lg">Filter</button>
                @if(request()->anyFilled(['search', 'group_id']))
                    <a href="{{ route('contacts.index') }}" class="text-red-500 text-xs font-black uppercase tracking-widest hover:text-red-400 ml-2">Clear</a>
                @endif
            </form>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/40 border-b border-slate-800 text-slate-500">
                        <tr>
                            <th class="py-5 px-8 text-[11px] font-black uppercase tracking-widest">Identity</th>
                            <th class="py-5 px-6 text-[11px] font-black uppercase tracking-widest">Details</th>
                            <th class="py-5 px-6 text-[11px] font-black uppercase tracking-widest">Category</th>
                            <th class="py-5 px-8 text-right text-[11px] font-black uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @forelse($contacts as $c)
                            <tr class="group hover:bg-slate-800/30 transition-all duration-300">
                                <td class="py-5 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            @if($c->image)
                                                <img src="{{ asset('storage/' . $c->image) }}" class="w-12 h-12 rounded-2xl object-cover ring-2 ring-slate-800 group-hover:ring-indigo-500/50 transition-all shadow-lg">
                                            @else
                                                <div class="w-12 h-12 rounded-2xl bg-slate-950 flex items-center justify-center text-slate-700 border border-slate-800">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                                                </div>
                                            @endif
                                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-slate-900 rounded-full"></div>
                                        </div>
                                        <div class="font-bold text-white group-hover:text-indigo-400 transition-colors">
                                            {{ $c->first_name }} {{ $c->last_name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div class="text-sm font-medium text-slate-300">{{ $c->email }}</div>
                                    <div class="text-[10px] font-mono text-slate-600 mt-1 uppercase">{{ $c->phone }}</div>
                                </td>
                                <td class="py-5 px-6">
                                    @if($c->group)
                                        <a href="{{ route('contacts.index', ['group_id' => $c->group->id]) }}" 
                                           class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500 hover:text-white transition-all">
                                            {{ $c->group->name }}
                                        </a>
                                    @else
                                        <span class="text-slate-700 text-[10px] font-bold italic tracking-widest uppercase">Unassigned</span>
                                    @endif
                                </td>
                                <td class="py-5 px-8">
                                    <div class="flex justify-end items-center gap-4">
                                        <a href="{{ route('contacts.edit', $c->id) }}" class="p-2 text-slate-600 hover:text-indigo-400 transition-all hover:bg-slate-800 rounded-xl">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('contacts.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Archive this contact?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-600 hover:text-red-500 transition-all hover:bg-slate-800 rounded-xl">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-800/50 rounded-full flex items-center justify-center text-slate-700 mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                        <p class="text-slate-500 font-bold italic">The database is currently empty.</p>
                                        <a href="{{ route('contacts.index') }}" class="mt-4 text-indigo-500 font-bold text-xs uppercase tracking-widest hover:underline">Show All</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>