<x-app-layout :meta-title="$post->title" :meta-description="$post->body">
    <div class="mx-auto mt-4 max-w-6xl bg-gray-400">
        @include('posts-components.post-article')
        @include('posts-components.form-create-response-post', ['post' => $post])
    </div>

    <div class="mx-auto mt-4 max-w-6xl bg-gray-400">
        @foreach($posts as $childPost)
            @include('posts-components.post-article',['post' => $childPost])
        @endforeach
    </div>

</x-app-layout>
