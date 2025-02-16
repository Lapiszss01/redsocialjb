<div>
    <button wire:click="toggleLike" class="text-xl flex items-center {{ $isLiked ? 'text-red-500' : 'text-gray-500' }}">
        {{ $likeCount }} Likes
    </button>
    <script>console.log('Livewire LikeButton Loaded');</script>
</div>
