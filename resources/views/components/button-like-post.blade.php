<div class="flex mt-2 items-center">

    <form action="{{route('post.like',$post)}}" method="post">
        @csrf
        <div class="flex items-center mr-2">
            <button type="submit" class="text-xs text-gray-500 flex items-center">
                {{$post->likes ? : 0}}
            </button>
        </div>
    </form>

</div>
