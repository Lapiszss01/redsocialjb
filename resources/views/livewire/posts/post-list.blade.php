<div class="mx-auto mt-4 max-w-6xl">
    <div
        class=" mt-8 grid gap-4 md:grid-cols-1 lg:grid-cols-1"
    >
        @auth
            <livewire:posts.post-form />
        @endauth

        @foreach($posts as $post)
            <livewire:posts.post-item :post="$post" :key="$post->id" />
        @endforeach
    </div>
</div>
