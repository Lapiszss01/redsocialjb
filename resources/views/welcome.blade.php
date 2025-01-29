<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl">
        <div
            class=" mt-8 grid gap-4 md:grid-cols-1 lg:grid-cols-1"
        >
            @auth
                @include('posts-components.form-create-post')
            @endauth



            @foreach($posts as $post)
                @include('posts-components.post-article')
            @endforeach
        </div>
    </div>
</x-app-layout>
