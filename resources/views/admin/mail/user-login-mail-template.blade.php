<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome Back</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f6f7fb; padding:20px;">

<div style="max-width:600px;margin:auto;background:#ffffff;padding:25px;border-radius:10px;">

    <h2 style="color:#2d3748;">
        👋 Welcome back, {{ $user->name }}!
    </h2>

    <p style="font-size:15px;color:#555;">
        We’re happy to see you again at <b>{{ config('app.name') }}</b>.
        You just logged into your account successfully.
    </p>

    <div style="background:#f1f5f9;padding:15px;border-radius:8px;margin:20px 0;">
        <p><b>Login Time:</b> {{ now() }}</p>
        <p><b>Email:</b> {{ $user->email }}</p>
        <p><b>IP Address:</b> {{ request()->ip() }}</p>
    </div>

    <p style="color:#444;">
        If this was not you, please secure your account immediately.
    </p>

    <a href="{{ url('/user-profile') }}"
       style="display:inline-block;padding:10px 18px;background:#4f46e5;color:#fff;text-decoration:none;border-radius:6px;">
        Go to Dashboard
    </a>

    <hr style="margin:25px 0;">

    <p style="font-size:12px;color:#888;">
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </p>

</div>

</body>
</html>
