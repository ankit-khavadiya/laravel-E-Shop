<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">

<div style="max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:8px;">

    <h2 style="color:#333;">Welcome, {{ $user->name }} 🎉</h2>

    <p>
        Thank you for registering with <b>{{ config('app.name') }}</b>.
        Your account has been successfully created.
    </p>

    <div style="background:#f0f0f0;padding:15px;border-radius:6px;margin:15px 0;">
        <p><b>Email:</b> {{ $user->email }}</p>
        <p><b>Registered At:</b> {{ $user->created_at }}</p>
    </div>

    <p>
        You can now log in and start shopping with us.
    </p>

    <a href="{{ route('login') }}"
       style="display:inline-block;padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;">
        Login Now
    </a>

    <hr style="margin:20px 0;">

    <p style="font-size:12px;color:#888;">
        If you did not create this account, please ignore this email.
    </p>

</div>

</body>
</html>
