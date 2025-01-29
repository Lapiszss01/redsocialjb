<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<article class="flex flex-col shadow my-4"
         onclick="function redirectToRoute(event, route) {
        const target = event.target;

        // Verifica si el click no fue en un enlace o botón
        if (!target.closest('a') && !target.closest('button')) {
            window.location.href = route;
        }
    }
    redirectToRoute(event, '{{ route('post.show',$post)}}')">
    <div class="bg-white flex flex-col justify-between p-6">
        <div class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
        <p href="#" class="text-sm pb-3">
            By <a  href="{{route("profile",$post->user->username)}}" class="font-semibold hover:text-gray-800"> {{ $post->user->name }}</a>, Published on {{$post->created_at}}
        </p>
            @auth
                @if(auth()->id() === $post->user->id)
                    <form action="{{ route('post.destroy', $post) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="hover:underline text-red-500">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            @endauth
        </div>
        <a href="#" class="pb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus quis porta dui. Ut eu iaculis massa. Sed ornare ligula lacus, quis iaculis dui porta volutpat. In sit amet posuere magna..</a>
        <div  class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between mt-3">
            <a href="{{ route('post.show', $post) }}" class="text-gray-800 hover:text-black">Responder <i class="fas fa-arrow-right"></i></a>
            <x-button-like-post :post="$post"/>
        </div>

    </div>
</article>
