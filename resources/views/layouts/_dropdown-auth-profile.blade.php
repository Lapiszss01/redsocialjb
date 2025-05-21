<x-slot name="trigger">
    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">

        @if(Auth::user()->profile_photo)
            <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                <img
                    src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : asset('images/default-profile.png') }}"
                    alt="Profile photo"
                    class="object-cover w-full h-full"
                >
            </div>
        @else
            <div>{{ Auth::user()->name }}</div>
        @endif

        <div class="ms-2">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </div>
    </button>
</x-slot>

<x-slot name="content">

    @if(Auth::user()->role_id == 1)
        <x-dropdown-link :href="route('admin.users')">
            {{ __('User Administration') }}
        </x-dropdown-link>
    @endif

    <x-dropdown-link :href="route('profile',Auth::user()->username)">
        {{ __('Profile') }}
    </x-dropdown-link>

    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-dropdown-link :href="route('logout')"
                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-dropdown-link>
    </form>
</x-slot>
