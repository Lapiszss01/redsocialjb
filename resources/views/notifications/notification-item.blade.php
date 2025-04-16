<article class="flex flex-col shadow my-4 mb-0">
    <div>
        <a href="{{ route('post.show', $notification->post_id) }}" class="font-semibold hover:text-gray-800">
            {{$notification->message}}
        </a>
    </div>
</article>
