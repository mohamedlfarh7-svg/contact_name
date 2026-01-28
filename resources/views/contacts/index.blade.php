<!DOCTYPE html>
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 md:p-12">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Contact Management</h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-10">
            <h2 class="text-xl font-semibold mb-4 text-blue-600">Add New Contact</h2>
            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="First Name" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400 outline-none" required>
                    <input type="text" name="last_name" placeholder="Last Name" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400 outline-none" required>
                    <input type="email" name="email" placeholder="Email" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400 outline-none" required>
                    <input type="text" name="phone" placeholder="Phone Number" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400 outline-none" required>
                    
                    <select name="group_id" class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400 outline-none bg-white" required>
                        <option value="">-- Select Group --</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                        Save Contact
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Email / Phone</th>
                        <th class="py-3 px-4">Group</th>
                        <th class="py-3 px-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-4 px-4 font-medium text-gray-900">
                                {{ $contact->first_name }} {{ $contact->last_name }}
                            </td>
                            <td class="py-4 px-4 text-gray-600 text-sm">
                                <div>{{ $contact->email }}</div>
                                <div class="text-xs text-gray-400">{{ $contact->phone }}</div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                                    {{ $contact->group->name ?? 'No Group' }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400 italic">No contacts found. Add your first contact above!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>