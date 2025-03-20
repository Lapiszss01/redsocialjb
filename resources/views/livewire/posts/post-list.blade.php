<div>
    @foreach($posts as $post)
        <livewire:posts.post-item :post="$post" :key="$post->id" />
    @endforeach
</div>
