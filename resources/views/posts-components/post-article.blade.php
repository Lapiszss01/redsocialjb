<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(postId) {

        Swal.fire({
            title: '¿Estás seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Borrar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + postId).submit();
            }
        });
    }
</script>

<article class="flex flex-col shadow my-4"
         onclick="function redirectToRoute(event, route) {
        const target = event.target;

        if (!target.closest('a') && !target.closest('button')) {
            window.location.href = route;
        }
    }
    redirectToRoute(event, '{{ route('post.show', $post) }}')">
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
    </div>
</article>


