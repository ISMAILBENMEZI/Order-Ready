<!DOCTYPE html>
<html>

<head>
    <style>
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ef4444;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }

        .container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }

        .reason-box {
            background-color: #fff1f2;
            padding: 15px;
            border-left: 4px solid #ef4444;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="color: #0f172a;">Hello,</h2>

        <p>We are writing to inform you that an action has been taken regarding your product:
            <strong style="color: #1e293b;">{{ $product->name }}</strong>.
        </p>

        <div class="reason-box">
            <strong style="color: #991b1b;">Reason for Action:</strong><br>
            {{ $reason }}
        </div>

        <p>To review the details and resolve this issue, please visit your seller dashboard:</p>

        <a href="{{ route('seller.store.statistics.reports',$product->store)}}" class="button">
            View Product Details
        </a>

        <p style="margin-top: 30px; font-size: 0.9em; color: #64748b;">
            Thank you for being part of our marketplace.<br>
            <em>Administration Team</em>
        </p>
    </div>
</body>

</html>
