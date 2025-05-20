<!DOCTYPE html>
<html>
<head>
    <title>Posts {{ $user->username }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h1 { text-align: center; }
        .post { margin-bottom: 20px; padding: 10px; border: 1px solid black; }
        .post h2 { margin: 0; font-size: 18px; }
        .post p { font-size: 14px; }
        .post img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Posts {{ $user->username }}</h1>

    @foreach ($posts as $post)
        <div class="post">
            <p>{{ $post->body }}</p>
            <p><strong>{{__('Publish date')}}:</strong> {{ $post->created_at->format('d/m/Y') }}</p>
            <p><strong>{{__('Likes')}}:</strong> {{ $post->likes->count() }}</p>
            <p><strong>{{__('Comments')}}:</strong> {{ $post->children->count() }}</p>

            @if ($post->image_url)
                <img src="{{ public_path('storage/' . $post->image_url) }}" alt="Imagen del post">
            @endif

        </div>
    @endforeach
</div>
</body>
</html>
