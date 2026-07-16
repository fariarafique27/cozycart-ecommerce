<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Order Confirmation</title>
</head>
<body style="font-family: sans-serif; background-color: #f5f5f4; padding: 40px; margin: 0; color: #44403c;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 32px; border-radius: 24px; border: 1px solid #e7e5e4;">
        <div style="text-align: center; margin-bottom: 24px;">
            <span style="font-size: 48px;">🧸</span>
            <h1 style="color: #db2777; margin-top: 12px; font-size: 24px;">Thank you for your order!</h1>
            <p style="color: #78716c; font-size: 14px;">We are packing up your plushies with extra love and care.</p>
        </div>

        <hr style="border: 0; border-top: 1px solid #e7e5e4; margin: 24px 0;">

        <h3 style="font-size: 16px; margin-bottom: 8px;">Order Details</h3>
        <p style="font-size: 14px; margin: 4px 0;"><strong>Order ID:</strong> #{{ $order->id }}</p>
        <p style="font-size: 14px; margin: 4px 0;"><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>

        <div style="margin-top: 32px; text-align: center;">
            <a href="{{ route('orders.index') }}" style="background-color: #db2777; color: white; padding: 12px 24px; text-decoration: none; font-weight: bold; border-radius: 12px; font-size: 14px; display: inline-block;">
                Track Your Order 📦
            </a>
        </div>
    </div>
</body>
</html>