<div style="font-family: sans-serif; padding: 20px;">
    <h1>Hello {{ $order->customer_name }}!</h1>
    <p>Your order #{{ $order->id }} status has been updated to: 
       <strong>{{ ucfirst($order->status) }}</strong>
    </p>
    
    @if($order->status == 'delivered')
        <p>Your plushies have arrived! We hope they bring you joy. 🧸</p>
    @else
        <p>We are sorry, but your order has been cancelled.</p>
    @endif
</div>