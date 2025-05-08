<!DOCTYPE html>
<html>
<head>
    <title>{{__("Mail liked post title")}}</title>
</head>
<body>
<h1>{!! __('Mail liked post h1', ['username' => $post->user->username]) !!}</h1>
<p>
    {!! __('Mail liked post p1', ['username2' => $user->username, 'body'=>$post->body]) !!}
</p>
<p>{{__("Mail liked post p2")}}!</p>
</body>
</html>
