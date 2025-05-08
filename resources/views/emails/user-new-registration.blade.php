<!DOCTYPE html>
<html>
<head>
    <title>{{__("Mail user registered title")}}</title>
</head>
<body>
<h1>{!! __('Mail user registered h1', ['username' => $user->username]) !!}</h1>
<p>{!! __("Mail user registered p1") !!}</p>
<p>{!! __("Mail user registered p2") !!}</p>
</body>
</html>
