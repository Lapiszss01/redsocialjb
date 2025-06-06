<div>
    @foreach($posts as $post)
        <livewire:posts.post-item :post="$post" :key="$post->id" :childPosts="$childPosts"  />
    @endforeach

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
</div>
