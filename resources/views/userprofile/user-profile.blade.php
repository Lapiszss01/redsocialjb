<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl bg-white p-4 rounded">
        <div>

            <div class="text-3xl">
                {{$user->name}}
                <span class="text-2xl text-gray-700">
                   - {{$user->username}}
               </span>
            </div>
            <br>
            <p>
                {{$user->biography}}
            </p>
            <br>
            <a href="{{ route('user.posts.pdf', ['id' => $user->id]) }}" class="btn btn-primary bg-white rounded p-2 my-4">
                Descargar Posts en PDF
            </a>
            <br>
            <div
                    class="mx-auto px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1"
            >
                @foreach($posts as $post)
                    @include('posts-components.post-article')
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

