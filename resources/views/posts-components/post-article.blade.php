
<article
    class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
    onclick="function redirectToRoute(event, route) {
        const target = event.target;

        // Verifica si el click no fue en un enlace o botón
        if (!target.closest('a') && !target.closest('button')) {
            window.location.href = route;
        }
    }
    redirectToRoute(event, '{{ route('post.show',$post)}}')"
>
    <div class="flex-1 space-y-3 p-5">

        <h2
            class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between"
        >
            <a class="hover:underline" href="{{route("profile",$post->user->username)}}">
                {{ $post->user->name }}
            </a>
            {{$post->created_at}}
        </h2>
            <p>
                {{ $post->body }}
            </p>

        @if($post->image != 0)
            <img src="{{ asset('images/' . $post->image) }}" alt="Imagen">
        @endif

        <div  class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">

            <a class="text-xl text-gray-500 flex" href="{{ route('post.show', $post) }}">Responder</a>
            <x-button-like-post :post="$post"/>
        </div>





    </div>
</article>
