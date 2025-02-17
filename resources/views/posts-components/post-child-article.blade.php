@foreach ($posts as $post)
    <article
        class="flex flex-col overflow-hidden rounded bg-white shadow dark:bg-slate-900"

    >
        <div class="bg-white flex flex-col justify-between p-6">
            <div class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
                <p class="text-sm pb-3">
                    <a href="{{ route('profile', $post->user->username) }}" class="font-semibold hover:text-gray-800">
                        {{ $post->user->name }}
                    </a>, {{ __('Published at') }} {{ $post->created_at }}
                </p>
                @auth
                    @if(auth()->id() === $post->user->id || auth()->user()->role_id === 1)
                        <form id="delete-form-{{ $post->id }}" action="{{ route('post.destroy', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="hover:underline text-red-500" onclick="confirmDelete({{ $post->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
            <a href="#" class="pb-6">{{ $post->body }}</a>
            <div class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between mt-3">
                <a href="{{ route('post.show', $post) }}" class="text-gray-800 hover:text-black">{{ __('Reply') }} <i class="fas fa-arrow-right"></i></a>

                <livewire:like-button :post="$post" />
            </div>
            @if ($post->children->isNotEmpty())
                @include('posts-components.post-child-article', ['posts' => $post->children, 'level' => ($level ?? 0) + 1])
            @endif
        </div>
    </article>
@endforeach
