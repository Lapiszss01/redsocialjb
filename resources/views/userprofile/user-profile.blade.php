<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">



<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl bg-white p-4 rounded">
        <div>
            <div class="text-3xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
                @if($user->profile_photo)
                <div class="w-40 h-40 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                    <img
                        src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('images/default-profile.png') }}"
                        alt="Profile photo"
                        class="object-cover w-full h-full"
                    >
                </div>
                @endif
                <div>
                    {{$user->name}}
                    <span class="text-2xl text-gray-700">
                       - {{$user->username}}
                   </span>
                </div>
                <x-dropdown align="right" width="48">
                    @include('userprofile.partials.slot-user-profile')
                </x-dropdown>
            </div>
            <br>
            <p>
                {{$user->biography}}
            </p>

            @if(Auth::user() && Auth::user()->id === $user->id)
                <div class="flex">
                    <form action="{{ route('posts.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required>
                        <button type="submit">Importar Posts</button>
                    </form>


                </div>
            @endif

            <div
                class="mx-auto px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1"
            >
                @foreach($posts as $post)
                    @if($post->published_at <= now() || Auth::id() === $user->id)
                        <livewire:posts.post-item :post="$post" :key="$post->id" />
                    @endif
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

