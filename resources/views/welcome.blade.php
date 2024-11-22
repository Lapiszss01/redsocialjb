<x-app-layout meta-title="Inicio" meta-description="Descripción de la página de Inicio">
    <div class="mx-auto mt-4 max-w-6xl">
        <h1 class="my-4 text-center font-serif text-4xl font-extrabold text-sky-600 md:text-5xl">
            Posts
        </h1>

        <div
            class="mx-auto mt-8 grid max-w-6xl gap-4 md:grid-cols-2 lg:grid-cols-3"
        >
            @foreach($posts as $post)
                <article
                    class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
                >
                    <div class="flex-1 space-y-3 p-5">

                        <h2
                            class="text-xl font-semibold leading-tight text-slate-800 dark:text-slate-200"
                        >
                            <a class="hover:underline" href="">
                                {{ $post->body }}
                            </a>
                        </h2>
                        <img src="{{ asset('images/' . $post->image) }}" alt="Imagen">
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-app-layout>
