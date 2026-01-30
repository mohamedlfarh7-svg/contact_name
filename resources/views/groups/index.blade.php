<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups Management | Dark Pro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1120; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1e293b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4f46e5; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-300 antialiased">

    <div class="max-w-6xl mx-auto px-6 py-16">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-6 border-b border-slate-800/60 pb-8">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight text-white mb-2">Groups <span class="text-indigo-500">Engine</span></h1>
                <p class="text-slate-500 font-medium">Categorize your network with precision.</p>
            </div>
            <a href="{{ route('contacts.index') }}" class="group flex items-center gap-3 px-6 py-3 rounded-xl bg-slate-900 border border-slate-700 text-sm font-bold text-slate-300 hover:bg-slate-800 hover:text-white transition-all shadow-xl">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Return to Contacts
            </a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <div class="lg:col-span-4">
                <div class="bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl sticky top-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">
                            {{ isset($group) ? 'Edit Group' : 'Add Group' }}
                        </h2>
                    </div>
                    
                    <form action="{{ isset($group) ? route('groups.update', $group->id) : route('groups.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if(isset($group)) @method('PUT') @endif
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Label Name</label>
                            <input type="text" name="name" value="{{ old('name', $group->name ?? '') }}" 
                                   placeholder="e.g. VIP Clients" 
                                   class="w-full bg-slate-950 border border-slate-800 px-5 py-4 rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all text-white placeholder:text-slate-700 shadow-inner" required>
                        </div>
                        
                        <div class="space-y-3">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-600/20 transition-all hover:shadow-indigo-600/40 active:scale-95">
                                {{ isset($group) ? 'Save Changes' : 'Confirm Group' }}
                            </button>

                            @if(isset($group))
                                <a href="{{ route('groups.index') }}" class="block text-center py-2 text-sm font-bold text-slate-600 hover:text-slate-400 transition">Cancel Edition</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-8">
                @if(session('success'))
                    <div class="bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 p-5 rounded-2xl mb-8 flex items-center justify-between">
                        <span class="font-bold flex items-center gap-3">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                            {{ session('success') }}
                        </span>
                        <button onclick="this.parentElement.remove()" class="text-indigo-400 hover:text-white">✕</button>
                    </div>
                @endif

                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
                    <div class="p-6 border-b border-slate-800 bg-slate-800/30">
                        <h3 class="font-bold text-white text-lg">Active Categories</h3>
                    </div>
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-slate-500 border-b border-slate-800">
                                    <th class="py-5 px-8 text-[11px] font-black uppercase tracking-widest">Name</th>
                                    <th class="py-5 px-6 text-[11px] font-black uppercase tracking-widest">Population</th>
                                    <th class="py-5 px-8 text-right text-[11px] font-black uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50">
                                @forelse($groups as $g)
                                    <tr class="group hover:bg-slate-800/40 transition-all duration-300">
                                        <td class="py-6 px-8">
                                            <a href="{{ route('contacts.index', ['group_id' => $g->id]) }}" class="font-bold text-slate-200 group-hover:text-indigo-400 transition-colors block">
                                                {{ $g->name }}
                                            </a>
                                        </td>
                                        <td class="py-6 px-6">
                                            <span class="px-4 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs font-bold text-indigo-400">
                                                {{ $g->contacts()->count() }} Contacts
                                            </span>
                                        </td>
                                        <td class="py-6 px-8">
                                            <div class="flex justify-end items-center gap-5">
                                                <a href="{{ route('groups.edit', $g->id) }}" class="text-slate-600 hover:text-indigo-400 transition-all transform hover:scale-110">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </a>
                                                <form action="{{ route('groups.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Delete category?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-slate-600 hover:text-red-500 transition-all transform hover:scale-110">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-20 text-center">
                                            <p class="text-slate-600 font-bold italic tracking-wide text-sm underline decoration-indigo-500/30">No groups configured yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>