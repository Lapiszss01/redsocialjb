<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div
        class=" mt-8 grid gap-4 md:grid-cols-1 lg:grid-cols-1"
    >
        <div class="mx-auto mt-4 max-w-6xl">
            @auth
                <livewire:posts.post-form />
            @endauth
            <livewire:posts.post-index/>
        </div>
    </div>
</x-app-layout>
