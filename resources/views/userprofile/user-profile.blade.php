<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<x-app-layout meta-title="{{ __('Inicio') }}" meta-description="{{ __('Descripción de la página de Inicio') }}">
    <div class="mx-auto mt-4 max-w-6xl bg-white p-4 rounded">
        <div>
            <div class="text-3xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
                @if($user->profile_photo)
                    <div class="w-40 h-40 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                        <img
                            src="{{ $user->profile_photo ? asset($user->profile_photo) : asset('images/default-profile.png') }}"
                            alt="{{ __('Foto de perfil') }}"
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
                {{ $user->biography ? $user->biography : __('Biografía no disponible') }}
            </p>

            @if(Auth::user() && Auth::user()->id === $user->id)
                <div class="gap-x-4 items-center">

                    <div class="h-10 flex items-center my-2">
                        <a href="{{ route('posts.template.download') }}"
                           class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-4 my-2 rounded text-sm leading-none h-full">
                            {{ __('Descargar Plantilla Excel') }}
                        </a>
                    </div>

                    <form action="{{ route('posts.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 y-10 py-2 ">
                        @csrf
                        <input type="file" name="file" id="file-upload" class="hidden" required onchange="document.getElementById('import-btn').disabled = false">

                        <label for="file-upload"
                               class="inline-flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded text-sm leading-none h-full cursor-pointer">
                            {{ __('Seleccionar archivo') }}
                        </label>

                        <button type="submit" id="import-btn" disabled
                                class="inline-flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm leading-none h-full">
                            {{ __('Importar Posts') }}
                        </button>
                    </form>

                </div>
                @if ($errors->any())
                    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
                        {{ session('warning') }}
                    </div>
                @endif
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
