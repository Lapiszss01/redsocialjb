<x-app-layout :meta-title="$post->title" :meta-description="$post->body">
    <div class="mx-auto mt-4 max-w-6xl">
        @include('posts-components.post-article')
        @include('posts-components.form-create-response-post', ['post' => $post])
    </div>

    <div class="mx-auto grid gap-4 mt-4 max-w-6xl">
        @if ($post->children)
            @include('posts-components.post-child-article', ['posts' => $post->children, 'level' => 0])
        @endif
    </div>

</x-app-layout>
