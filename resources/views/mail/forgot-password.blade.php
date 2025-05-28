<!DOCTYPE html>
<html lang="en" style="margin: 0; padding: 0; border: 0;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Link</title>

</head>
<body style="border: 0; background-color: #dddddd; font-size: 16px; max-width: 700px; margin: 0 auto; padding: 2%; color: #000000; font-family: 'Open Sans', sans-serif;">
    <div class="container" style="margin: 0; padding: 0; border: 0; background-color: #ffffff;">
        <div class="logo" style="margin: 0; border: 0; padding: 1%; text-align: center;">
            <img src="{{asset('logo-dark.png')}}" style="margin: 0; padding: 0; border: 0; max-width: 120px;">
        </div>

        <div class="one-col" style="margin: 0; border: 0; padding: 20px 10px 40px; text-align: center;">
            <h1 style="margin: 0; padding: 0; border: 0; padding-bottom: 15px; letter-spacing: 1px;">Hi, {{$username}}</h1>
            <p style="margin: 0; padding: 0; border: 0; line-height: 28px; padding-bottom: 25px;">We received a request to reset your password. Please follow this link to reset your password.</p>
            <a href="{{$link}}" style="background-color: #d73644; color: #ffffff; text-decoration: none; font-weight: 700; padding: 10px 15px; border-radius: 10px;">Reset Password</a>
            <p style="margin: 0; padding: 0; border: 0; line-height: 28px; padding-bottom: 25px; margin-top: 25px;">If You didn't requested for reset your password. Ignore this email.</p>
        </div>
    </div>
</body>
</html>
