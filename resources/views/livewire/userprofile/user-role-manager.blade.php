<div class="px-4 py-6 space-y-6 max-w-7xl mx-auto">

    <div class="flex flex-wrap gap-3">
        <button wire:click="analysisPDF"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
            {{ __('Stadistics') }}
        </button>

        <button wire:click="deleteInactiveUsers"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
            {{ __('Delete Inactive Users') }}
        </button>

        <button wire:click="deleteInactivePosts"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
            {{ __('Delete Inactive Posts') }}
        </button>

    </div>

    @if ($message)
        <div class="text-green-600 font-semibold">
            {{ $message }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2 text-left">{{ __('Name') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Email') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Role') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <livewire:components.selectcomponent
                            :userId="$user->id"
                            :roleId="$user->role_id"
                            :key="$user->id" />
                    </td>
                    <td class="px-4 py-2 space-y-1">
                        <button wire:click="editUser({{ $user->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                            {{ __('Edit Profile') }}
                        </button>

                        <button wire:click="confirmDelete({{ $user->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                            {{ __('Delete Profile') }}
                        </button>

                        <button wire:click="generateToken({{ $user->id }})"
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                            {{ __('Generate Token') }}
                        </button>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="px-4 py-4">
                    <button wire:click="openUserCreating()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                        {{ __('Create User') }}
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    @if($generatedToken)
        <div class="bg-gray-100 border border-gray-300 rounded p-4 mt-4">
            <h3 class="font-semibold">{{ __('Token') }}:</h3>
            <p class="mt-2 text-sm font-mono text-gray-800 break-words">
                {{ $generatedToken }}
            </p>
        </div>
    @endif

    @if ($editingUser)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-60 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">{{ __('Edit Profile') }}</h2>

                <label class="block mb-2">{{ __('Name') }}</label>
                <input type="text" wire:model="name" class="border p-2 w-full mb-4 rounded">

                <label class="block mb-2">{{ __('Email') }}</label>
                <input type="email" wire:model="email" class="border p-2 w-full mb-4 rounded">

                <div class="flex justify-end space-x-2">
                    <button wire:click="updateUser"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        {{ __('Save') }}
                    </button>
                    <button wire:click="$set('editingUser', false)"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if ($creatingUser)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-60 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">{{ __('Create User') }}</h2>

                <label class="block mb-2">{{ __('Name') }}</label>
                <input type="text" wire:model="name" class="border p-2 w-full mb-4 rounded">

                <label class="block mb-2">{{ __('Username') }}</label>
                <input type="text" wire:model="username" class="border p-2 w-full mb-4 rounded">

                <label class="block mb-2">{{ __('Email') }}</label>
                <input type="email" wire:model="email" class="border p-2 w-full mb-4 rounded">

                <label class="block mb-2">{{ __('Password') }}</label>
                <input type="password" wire:model="password" class="border p-2 w-full mb-4 rounded">

                <div class="flex justify-end space-x-2">
                    <button wire:click="createUser"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        {{ __('Save') }}
                    </button>
                    <button wire:click="$set('creatingUser', false)"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded">
            {{ session('message') }}
        </div>
    @endif

</div>
