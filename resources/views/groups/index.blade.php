<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Contact Groups</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-xl font-bold mb-4 text-blue-600">Contact Groups</h1>

        <form action="{{ route('groups.store') }}" method="POST" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="name" placeholder="Group name..." 
                   class="border p-2 flex-1 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Add
            </button>
        </form>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <ul class="divide-y divide-gray-200">
            @forelse($groups as $group)
                <li class="py-2 text-gray-700 flex justify-between">
                    <span>{{ $group->name }}</span>
                    <span class="text-xs text-gray-400">{{ $group->created_at->format('d/m') }}</span>
                </li>
            @empty
                <li class="py-2 text-gray-400 text-center italic">No groups yet.</li>
            @endforelse
        </ul>
    </div>

</body>
</html>