<div class="flex mt-2 items-center">

    <form action="{{route('post.response',$post)}}" method="post">
        @csrf
        <div class="flex items-center mr-2">
            <button type="submit" class="text-xl text-gray-500 flex items-center">
                {{$post->likes->where('liked', true)->count() ?: 0}} Likes
            </button>
        </div>
    </form>

</div>
