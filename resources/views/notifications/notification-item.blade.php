<article class="bg-white shadow rounded-lg p-4 my-2 border border-gray-200 hover:shadow-md transition">
    <a href="{{ route('post.show', $notification->post_id) }}" class="block space-y-1">
        <div class="flex items-center justify-between text-sm text-gray-600">
            <span class="font-semibold text-indigo-600">
                {{ $notification->actor->username }}
            </span>

            @if($notification->pivot->relation_type === 'like')
                <span class="flex items-center gap-1 text-pink-600 bg-pink-100 px-2 py-0.5 rounded-full text-xs">
                    {{ __('Like') }}
                </span>
            @else
                <span class="flex items-center gap-1 text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full text-xs">
                    {{ __('Comment') }}
                </span>
            @endif
        </div>

        <div class="text-gray-800 text-sm line-clamp-2">
            {{ $notification->post->body }}
        </div>
    </a>
</article>
