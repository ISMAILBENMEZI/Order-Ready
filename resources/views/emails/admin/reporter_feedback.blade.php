<!DOCTYPE html>
<html>

<head>
    <style>
        .container {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #334155;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #f1f5f9;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
        }

        .message-box {
            background-color: #f8fafc;
            padding: 15px;
            border-left: 4px solid #3b82f6;
            margin: 20px 0;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="color: #0f172a;">Thank you for your report</h2>

        <p>Hello,</p>

        <p>Our team has finished reviewing the report you submitted regarding
            <strong>{{ $report->product->name ?? 'a product' }}</strong>.
        </p>

        <div class="status-badge">Status: {{ $report->status }}</div>

        <div class="message-box">
            <strong>Admin Feedback:</strong><br>
            {{ $feedback }}
        </div>

        <p>Your contribution helps keep our community safe and reliable. We appreciate your vigilance!</p>

        <p style="margin-top: 30px; font-size: 0.9em; color: #64748b;">
            Best regards,<br>
            <em>The Support Team</em>
        </p>
    </div>
</body>

</html>
