<!DOCTYPE html>
<html>
<head>
    <title>{{__("Mail post deleted title")}}</title>
</head>
<body>
<h1>{{__("Mail post deleted h1")}}</h1>
<p>{!! __('Mail post deleted p1', ['title' => $post->title]) !!}</p>
<p>{{__("Mail post deleted p2")}}</p>
</body>
</html>
