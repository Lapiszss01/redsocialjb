<article
    class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"
>
    <div class="flex-1 space-y-3 p-5">

        <h2
            class="text-xl leading-tight text-slate-800 dark:text-slate-200"
        >
            <a class="hover:underline" href="{{route("profile",$post->user->username)}}">
                {{ $post->user->name }}
            </a>
            <p>
                {{ $post->body }}
            </p>
        </h2>
        @if($post->image != 0)
            <img src="{{ asset('images/' . $post->image) }}" alt="Imagen">@endif
    </div>
</article>
