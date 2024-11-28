<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl">


        <div
            class="px-4 mt-8 grid max-w-4xl gap-4 md:grid-cols-1 lg:grid-cols-1"
        >
            <form method="POST" action="{{ route('post.store') }}">
                <article
                    class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
                >
                    <x-textarea-post-input id="body" name="body"></x-textarea-post-input>
                    <button type="submit" class="p-2">
                        Postear
                    </button>
                </article>
                @csrf
            </form>

            @foreach($posts as $post)
                @include('components.post-article')
            @endforeach
        </div>
    </div>
</x-app-layout>
