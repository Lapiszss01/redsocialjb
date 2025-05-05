<article class="flex flex-col shadow my-4 mb-0">
    <div>
        <a href="{{ route('post.show', $notification->post_id) }}" class="font-semibold hover:text-gray-800">
            <div>
                {{$notification->actor->username}} -
                @if($notification->pivot->relation_type == 'like')
                {{__('Like')}}
                @else
                    {{__('Comment')}}
                @endif
            </div>
            <div class="font-medium">
                {{$notification->post->body}}
            </div>
        </a>
    </div>
</article>
