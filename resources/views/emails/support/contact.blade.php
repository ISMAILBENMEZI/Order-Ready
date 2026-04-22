<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }

        .header {
            background-color: #2563eb;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }

        .content {
            padding: 30px;
            background-color: #ffffff;
        }

        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }

        .info-label {
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            display: block;
            margin-bottom: 4px;
        }

        .info-value {
            display: block;
            margin-bottom: 20px;
            color: #475569;
            font-size: 16px;
        }

        .message-box {
            background-color: #f1f5f9;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #2563eb;
            font-style: italic;
        }

        .badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">Order Ready</h1>
            <p style="margin: 5px 0 0; opacity: 0.8;">New Support Inquiry</p>
        </div>

        <div class="content">
            <div style="margin-bottom: 30px;">
                <span class="info-label">From</span>
                <span class="info-value">{{ $data['name'] }} ({{ $data['email'] }})</span>

                <span class="info-label">Subject</span>
                <span class="info-value">
                    <span class="badge">{{ $data['subject'] }}</span>
                </span>
            </div>

            <div style="border-top: 1px solid #f1f5f9; pt: 20px;">
                <span class="info-label">Message Details</span>
                <div class="message-box">
                    "{{ $data['message'] }}"
                </div>
            </div>
        </div>

        <div class="footer">
            <p>This email was sent via the Order Ready Contact Form.</p>
            <p>&copy; {{ date('Y') }} Order Ready Platform. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
