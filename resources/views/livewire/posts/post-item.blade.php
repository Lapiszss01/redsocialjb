
<article class="flex flex-col shadow my-4 mb-0">
    <div class="bg-white flex flex-col justify-between p-6">
        <div class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between">
            <div class="flex items-center space-x-2">
                @if($post->user->profile_photo)
                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                    <img
                        src="{{ $post->user->profile_photo ?  asset($post->user->profile_photo) : asset('images/default.png') }}"
                        alt="Profile photo"
                        class="object-cover w-full h-full"
                    >
                </div>
                @endif
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <a href="{{ route('profile', $post->user->username) }}" class="font-semibold hover:text-gray-800">
                        {{ $post->user->name }}
                    </a>,
                    {{ __('Published at') }} {{ $post->published_at }}
                </p>
            </div>
            @auth
                @if(auth()->id() === $post->user->id || auth()->user()->role_id === 1 || auth()->user()->role_id === 2)
                    <button wire:click="delete" class="hover:underline text-red-500">
                        <i class="fas fa-trash"></i>
                    </button>
                @endif
            @endauth
        </div>
        <p class="pb-6">{{ $post->body }}</p>

        @if($post->image_url)
            <img src="{{ asset('storage/' . $post->image_url) }}" alt="Imagen del post" class="p-1 w-full max-w-lg h-auto object-cover rounded-lg mx-auto">
        @endif

        <div class="text-xl leading-tight text-slate-800 dark:text-slate-200 flex justify-between mt-3">
            <a href="#" wire:click.prevent="redirectToPost({{ $post->id }})" class="text-gray-800 hover:text-black">
                {{ __('Reply') }} <i class="fas fa-arrow-right"></i>
            </a>
            <button wire:click="toggleLike" class="text-xl flex items-center {{ $isLiked ? 'text-red-500' : 'text-gray-500' }}">
                {{ $likeCount }} Likes
            </button>
        </div>
    </div>
</article>
