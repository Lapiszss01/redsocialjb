<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl">


        <div
            class="px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1 "
        >
            @foreach($posts as $post)
                @include('components.post-article')
            @endforeach
        </div>
    </div>
</x-app-layout>
