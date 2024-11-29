<article
    class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
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

        <x-button-like-post :post="$post"/>



    </div>
</article>
