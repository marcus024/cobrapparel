<!DOCTYPE html>
<html>
<head>
    <title>New Notification</title>
   
    <style>
       body {
    background-color: #f3f4f6;
    margin: 0; /* Removes default margin */
    padding: 20px; /* Reduces padding */
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Centers content vertically */
}

.container {
    max-width: 640px;
    width: 100%;
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    margin-left: 20px; /* Adjust this value as needed */
}


.header {
    background-color: #700101;
    color: white;
    text-align: center;
    padding: 24px;
}

.header img {
    height: 56px;
    display: block;
    margin: 0 auto;
}

.header h1 {
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
}

.content {
    padding: 32px;
    background-color: #f9fafb;
    margin-left:20px;
}

.content h2 {
    font-size: 24px;
    font-weight: bold;
    color: #700101;
    padding-left:20px;
}

.content p {
    margin-top: 10px;
    color: #4b5563;
}

.order-summary {
    margin-top: 24px;
}

.order-summary h3 {
    font-size: 18px;
    font-weight: 600;
    color: #1f2937;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 8px;
}

.order-list {
    list-style: none;
    padding: 0;
    margin-top: 16px;
}

.order-item {
    background: white;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.order-item div {
    font-weight: 600;
}

.order-item span {
    color: #700101;
    font-weight: bold;
}

.section-box {
    margin-top: 24px;
    padding: 16px;
    background-color: #700101;
    color: white;
    border-radius: 8px;
}

.section-box h3 {
    font-size: 16px;
    font-weight: 600;
}

.section-box p {
    font-size: 14px;
    margin-top: 6px;
}

.footer {
    background-color: #700101;
    color: white;
    text-align: center;
    padding: 16px;
}

.footer p {
    font-size: 14px;
    margin: 6px 0;
}

.footer a {
    color: white;
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <img src="https://144175632.fs1.hubspotusercontent-eu1.net/hubfs/144175632/Cobra%20Head%20-%20White%20on%20Maroon.png" alt="Cobrapparel Logo" class="logo">
            <h1>New Order Notification</h1>
        </div>

        <!-- Email Body -->
        <div class="body">
            <h2 style="margin-left:20px;">You have received a new order!</h2>
            <p style="margin-left:20px;">Order ID: <strong>{{ $order->order_id }}</strong></p>
            <p style="margin-left:20px;">A customer has placed a new order. Please review the details below.</p>

            <!-- Order Summary -->
           <div class="order-summary">
                <h3 style="margin-left:20px;">Order Summary</h3>
                <ul>
                    @php
                        $subtotal = 0;
                    @endphp

                    @foreach($orderItems as $item)
                        @php
                            $itemTotal = $item->price * $item->quantity;
                            $subtotal += $itemTotal;
                        @endphp
                        <li class="order-item">
                            <div>
                                <span class="item-name">{{ $item->product_name }}</span><br>
                                <span class="item-quantity">Quantity: {{ $item->quantity }}</span><br>
                                @if(!empty($item->size))
                                    <span class="item-size">Size: {{ $item->size }}</span><br>
                                @endif
                                @if(!empty($item->custom_name))
                                    <span class="item-custom-name">Custom Name: {{ $item->custom_name }}</span><br>
                                @endif
                                @if(!empty($item->custom_number))
                                    <span class="item-custom-number">Custom Number: {{ $item->custom_number }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="reference-code mt-3" style="margin-left: 20px;">
                    <p><strong>Reference Code:</strong> {{ $order->reference_code }}</p>
                </div>

                <!-- Display Total Amount Including GST -->
                @php
                    $gst = $subtotal * 0.10;
                    $totalWithGST = $subtotal + $gst;
                @endphp

                <div class="total-summary mt-4" style="margin-left: 20px;">
                    <p><strong>We have received a total (including GST) of ${{ number_format($totalWithGST, 2) }}.</strong></p>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="customer-details">
                <h3 style="margin-left:20px;">Customer Details</h3>
                <p style="margin-left:20px;">
                    Name: {{ $order->first_name }} {{ $order->last_name }}<br>
                    Email: {{ $order->email }}<br>
                    Phone: {{ $order->phone }}
                </p>
            </div>

            <!-- Shipping Address -->
            <div style="margin-left:20px;" class="shipping-address">
                <h3 style="margin-left:20px;">Shipping Address</h3>
                <p style="margin-left:20px;">
                    {{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->postcode }}
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Please process the order as soon as possible.</p>
            <p>
                <a href="https://cobrapparel.com/admin/orders">Manage Orders</a>
            </p>
        </div>
    </div>
</body>
</html>
