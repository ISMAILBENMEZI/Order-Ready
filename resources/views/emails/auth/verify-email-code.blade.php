<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:40px;">

    <div style="max-width:500px;margin:auto;background:white;padding:30px;border-radius:8px;text-align:center">

        <h2 style="color:#333;">Verify Your Email</h2>

        <p style="color:#555;">
            Thank you for creating an account.
        </p>

        <p style="color:#555;">
            Please use the verification code below:
        </p>

        <div style="font-size:32px;font-weight:bold;letter-spacing:6px;margin:20px 0;color:#2563eb;">
            {{ $code }}
        </div>

        <p style="color:#888;font-size:14px;">
            This code will expire in 10 minutes.
        </p>

        <p style="color:#aaa;font-size:12px;margin-top:30px;">
            Order Ready Platform
        </p>

    </div>

</body>

</html>
