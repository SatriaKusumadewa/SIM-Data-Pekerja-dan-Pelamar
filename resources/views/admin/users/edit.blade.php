<x-layouts.admin title="Edit User">
    <div class="bg-white shadow rounded max-w-3xl">
        <div class="px-6 py-5 border-b">
            <h1 class="text-2xl font-semibold">Edit User</h1>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-4 text-red-700 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block mb-1 text-sm font-medium">Nama User</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Password Baru (opsional)</label>
                    <input type="password" name="password" class="w-full border rounded p-2 text-sm">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium">Role</label>
                    <select name="role" class="w-full border rounded p-2 text-sm">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-sky-600 text-white px-6 py-2 rounded text-sm">
                        Simpan
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                       class="bg-gray-300 text-gray-800 px-6 py-2 rounded text-sm">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>