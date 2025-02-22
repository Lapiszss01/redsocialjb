<!DOCTYPE html>
<html>
<head>
    <title>Posts de {{ $user->username }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h1 { text-align: center; }
        .post { margin-bottom: 20px; padding: 10px; border-bottom: 1px solid #ddd; }
        .post h2 { margin: 0; font-size: 18px; }
        .post p { font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Posts de {{ $user->username }}</h1>

    @foreach ($posts as $post)
        <div class="post">
            <p>{{ $post->body }}</p>
            <small><strong>Fecha:</strong> {{ $post->created_at->format('d/m/Y') }}</small>
        </div>
    @endforeach
</div>
</body>
</html>
