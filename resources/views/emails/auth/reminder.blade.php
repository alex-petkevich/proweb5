<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>{!! trans('emails.password_reset') !!}</h2>

<div>
    {!! trans('emails.complete_form') !!}: {!! URL::to('password/reset', array($token)) !!}.
</div>
</body>
</html>