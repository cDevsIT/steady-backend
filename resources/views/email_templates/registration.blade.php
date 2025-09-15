<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email</title>
</head>
<body>
<h2>Dear {{$user->first_name}} {{$user->last_name}}</h2>
<p><strong>Email:</strong> {{$user->email}}</p>
<p><strong>Password:</strong> {{$password}}</p>
<p>Please login your account</p>
</body>
</html>
