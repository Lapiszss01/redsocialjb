<!DOCTYPE html>
<html>
<head>
    <title>Análisis General del Blog</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .stats { margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Análisis General del Blog</h1>

    <div class="stats">
        <p><strong>Total de usuarios:</strong> {{ $totalUsers }}</p>
        <p><strong>Total de posts (incluyendo comentarios):</strong> {{ $totalPosts }}</p>
        <p><strong>Total de posts principales:</strong> {{ $totalMainPosts }}</p>
        <p><strong>Total de comentarios:</strong> {{ $totalComments }}</p>
        <p><strong>Promedio de comentarios por post:</strong> {{ $avgCommentsPerPost }}</p>
        <p><strong>Total de temas:</strong> {{ $totalTopics }}</p>
    </div>

    <h2>Top Usuarios por Cantidad de Posts</h2>
    <table>
        <thead><tr><th>Usuario</th><th>Posts</th></tr></thead>
        <tbody>
        @foreach($topUsers as $user)
            <tr><td>{{ $user->username }}</td><td>{{ $user->posts->count() }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <h2>Topics Más Usados</h2>
    <table>
        <thead><tr><th>Tema</th><th>Posts</th></tr></thead>
        <tbody>
        @foreach($topTopics as $topic)
            <tr><td>{{ $topic->name }}</td><td>{{ $topic->posts->count() }}</td></tr>
        @endforeach
        </tbody>
    </table>

    <h2>Posts Más Likeados</h2>
    <table>
        <thead><tr><th>Post</th><th>Autor</th><th>Likes</th></tr></thead>
        <tbody>
        @foreach($topLikedPosts as $post)
            <tr>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 50) }}</td>
                <td>{{ $post->user->username }}</td>
                <td>{{ $post->likes_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Posts con Más Comentarios</h2>
    <table>
        <thead><tr><th>Post</th><th>Autor</th><th>Comentarios</th></tr></thead>
        <tbody>
        @foreach($mostCommentedPosts as $post)
            <tr>
                <td>{{ \Illuminate\Support\Str::limit($post->body, 50) }}</td>
                <td>{{ $post->user->username }}</td>
                <td>{{ $post->comments_count }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
