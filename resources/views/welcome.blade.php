<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mt-8 grid gap-4 md:grid-cols-3 max-w-6xl mx-auto p-4">
        <div class="md:col-span-2 flex flex-col space-y-4 w-full">
            @auth
            <div class="bg-white p-4 shadow-md rounded-lg w-full">
                <livewire:posts.post-form />
            </div>
            @endauth
            <div class="bg-white p-4 shadow-md rounded-lg w-full">
                <livewire:posts.post-index />
            </div>

        </div>

        <div class="bg-white p-4 shadow-md rounded-lg w-full">
            <livewire:components.listview :title="'Tópicos más usados'" :source="'topics'" />

            <livewire:components.listview :title="'Usuarios con más posts'" :source="'users'" />
        </div>
    </div>




</x-app-layout>
