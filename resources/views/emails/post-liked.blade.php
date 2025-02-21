<!DOCTYPE html>
<html>
<head>
    <title>Notificación de Like</title>
</head>
<body>
<h1>¡Hola, {{ $post->user->username }}!</h1>
<p>El usuario <strong>{{ $user->username }}</strong> le ha dado like a tu post: <strong>{{ $post->body }}</strong>.</p>
<p>¡Revisa tu post ahora!</p>
</body>
</html>
