<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">



<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl bg-white p-4 rounded">
        <div>

            <div class="text-3xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
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
            <div
                class="mx-auto px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1"
            >
                @foreach($posts as $post)
                    <livewire:posts.post-item :post="$post" :key="$post->id" />
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

