<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    background-color: #f3f4f6;
    padding: 40px 0;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 640px;
    margin: 0 auto;
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

/* Header */
.header {
    background-color: #700101;
    color: white;
    text-align: center;
    padding: 24px;
}

.logo {
    height: 56px;
    display: block;
    margin: 0 auto 10px;
}

/* Body */
.body {
    padding: 32px;
    background-color: #f9fafb;
}

.body h2 {
    color: #700101;
    font-size: 24px;
    font-weight: bold;
}

.body p {
    color: #4b5563;
    margin-top: 8px;
}

/* Order Summary */
.order-summary {
    margin-top: 24px;
}

.order-summary h3 {
    font-size: 20px;
    font-weight: bold;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 8px;
}

.order-item {
    background-color: white;
    padding: 16px;
    border-radius: 6px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 12px;
}

.item-name {
    font-weight: bold;
}

.item-quantity {
    font-size: 14px;
    color: #6b7280;
}

.item-price {
    font-weight: bold;
    color: #700101;
}

/* Shipping Address */
.shipping-address {
    margin-top: 24px;
    padding: 16px;
    background-color: #700101;
    color: white;
    border-radius: 6px;
}

.shipping-address h3 {
    font-size: 18px;
    font-weight: bold;
}

/* Footer */
.footer {
    background-color: #700101;
    color: white;
    text-align: center;
    padding: 16px;
}

.footer a {
    color: white;
    text-decoration: underline;
}

    </style>
</head>
<body>
      <div class="container">
        <!-- Header with Logo and Brand Color -->
        <div class="header">
            <img src="https://144175632.fs1.hubspotusercontent-eu1.net/hubfs/144175632/Cobra%20Head%20-%20White%20on%20Maroon.png" alt="Cobrapparel Logo" class="logo">
            <h1>Order Confirmation</h1>
        </div>

        <!-- Email Body -->
        <div class="body">
            <h2>Thank you for your order, {{ $order->first_name }}!</h2>
            <p>Your Order ID: <strong>{{ $order->order_id }}</strong></p>
            <p>We have received your order and it is currently being processed.</p>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                <ul>
                    @foreach ($orderItems as $item)
                        <li class="order-item">
                            <div>
                                <span class="item-name">{{ $item->product_name }}</span><br>
                                <span class="item-quantity">Quantity: {{ $item->quantity }}</span>
                            </div>
                            <span class="item-price">${{ number_format($item->price, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Shipping Address -->
            <div class="shipping-address">
                <h3>Shipping Address</h3>
                <p style="color:rgb(199, 193, 193);">
                    {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->postcode }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p><a href="https://cobrapparel.com/">Visit our store</a></p>
        </div>
    </div>
</body>
</html>