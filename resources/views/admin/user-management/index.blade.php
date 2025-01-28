<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __('Total Users') }}: {{ $totalUsers }}</p>
                    <form id="user-form" action="{{ route('admin.user-management.bulk-action') }}" method="POST">
                        @csrf
                    </form>
                    <select form="user-form" name="action" class="form-control">
                        <option value="">Select Action</option>
                        <option value="delete">Delete</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="ban">Ban</option>
                    </select>
                    <button  form="user-form" type="submit"
                        class="text-white bg-purple-700 hover:bg-blue-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                    >Apply</button>
                    <a href="{{ route('admin.user-management.create') }}" 
                        class="text-white bg-purple-700 hover:bg-blue-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                    >Add New User</a>
                    <table class="table" style="width:100%;text-align:left;">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="even:bg-gray-50 odd:bg-white">
                                    <td><input form="user-form" type="checkbox" name="selected_users[]" value="{{ $user->id }}"></td>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        @if ($user->getFirstMedia())
                                            <img src="{{ $user->getFirstMedia()->getUrl('thumbnail') }}" alt="Profile" class="mb-2">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->status }}</td>
                                    <td>
                                        <button
                                            class="text-white bg-green-700 hover:bg-green-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            onclick="location.href='{{ route('admin.user-management.edit', $user) }}';return false;"
                                        >{{ __('Edit') }}</button>
                                        <form id="delete-form-{{ $user->id }}" class="delete-form" action="{{ route('admin.user-management.destroy', $user) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button form="delete-form-{{ $user->id }}" type="submit"
                                            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            onclick="return confirm('Are you sure you want to delete this user?')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="selected_users[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }.bind(this));
        });
    </script>
</x-app-layout>