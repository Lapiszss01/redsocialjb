<x-app-layout :meta-title="$post->title" :meta-description="$post->body">
    <div class="mx-auto mt-4 max-w-6xl">
        <livewire:posts.post-item :post="$post" :key="$post->id" />
        <livewire:posts.post-form :parentpost="$post"/>
    </div>

    <div class="mx-auto mt-4 max-w-6xl">
        @if ($post->children)
            <livewire:posts.post-index :childPosts="$post->children" :post_id="$post->id"/>
        @endif
    </div>

</x-app-layout>
