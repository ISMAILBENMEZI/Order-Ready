<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #2563eb;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }

        .content {
            padding: 40px 30px;
            line-height: 1.6;
            text-align: center;
        }

        .button-container {
            padding: 20px 0;
        }

        .button {
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
        }

        .footer {
            background-color: #f1f5f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }

        .link-text {
            word-break: break-all;
            color: #2563eb;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">Order Ready</h1>
        </div>

        <div class="content">
            <h2 style="color: #1e293b; margin-top: 0;">Reset Your Password</h2>
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account. No further
                action is required if you did not make this request.</p>

            <div class="button-container">
                <a href="{{ $url }}" class="button">Reset Password</a>
            </div>

            <p style="font-size: 14px; color: #64748b;">This password reset link will expire in 60 minutes.</p>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

            <p style="font-size: 12px; color: #94a3b8; text-align: left;">
                If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your
                web browser:
                <br>
                <span class="link-text">{{ $url }}</span>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Order Ready. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
