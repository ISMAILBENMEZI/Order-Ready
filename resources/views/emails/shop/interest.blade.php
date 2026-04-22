<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        .button {
            background-color: #2563eb;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
        }

        .container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .product-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h2 style="color: #1e293b; margin-top: 0;">🔥 New Interest in Your Product!</h2>

            <p style="color: #475569; font-size: 16px;">
                Hi there, we have some good news. User <strong>{{ $buyer->name }}</strong> is very interested in buying
                your product:
            </p>

            <div
                style="border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 15px 0; margin: 20px 0;">
                <h3 style="color: #0f172a; margin-bottom: 5px;">{{ $product->name }}</h3>
                <p style="color: #2563eb; font-weight: 900; font-size: 20px; margin: 0;">
                    ${{ number_format($product->price, 2) }}
                </p>
                @if ($product->primaryImage)
                    <img src="{{ $product->primaryImage->image_url }}" alt="{{ $product->name }}" class="product-img">
                @endif
            </div>

            <p style="color: #64748b; font-size: 14px;">
                Don't keep them waiting! Connect with them now via your dashboard to finalize the sale.
            </p>

            <a href="{{ url('/chat/inbox') }}" class="button">Reply to Buyer Now</a>

            <p style="margin-top: 30px; font-size: 12px; color: #94a3b8; text-align: center;">
                You received this email because you have an active listing on our platform.
            </p>
        </div>
    </div>
</body>

</html>
