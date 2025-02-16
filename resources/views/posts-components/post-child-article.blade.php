@foreach ($posts as $post)
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

            <div  class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
                <a class="text-xl text-gray-500 flex" href="{{ route('post.show', $post) }}">{{__("Reply")}}</a>
                <livewire:like-button :post="$post" />
            </div>



        @if ($post->children->isNotEmpty())
            @include('posts-components.post-child-article', ['posts' => $post->children, 'level' => ($level ?? 0) + 1])
        @endif
    </div>
    </article>
@endforeach
