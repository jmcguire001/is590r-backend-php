<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <h1>Hello {{ $user->name }}</h1>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <a href="http://127.0.0.1:8000/api/password_reset?remember_token={{$user->remember_token}}">Reset Password</a>
</body>
</html>