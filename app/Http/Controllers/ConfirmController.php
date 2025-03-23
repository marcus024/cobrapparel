<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Mail\ShopOwnerNotificationMail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Stripe\Exception\ApiErrorException;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
class ConfirmController extends Controller
{
    public function success(Request $request)
    {
        Stripe::setApiKey(config('stripe.test.sk'));

        // Get the Stripe session_id from the request
        $session_id = $request->query('session_id');

        $session = Session::retrieve($session_id, ['expand' => ['line_items']]);

        $validatedData = session('checkout_data');

        if (!$validatedData) {
            return response()->json(['error' => 'Session data not found'], 400);
        }

        if (!$session_id) {
            return redirect()->route('checkout')->with('error', 'Invalid session.');
        }

        // Retrieve session details from Stripe
        try {
            $session = Session::retrieve($session_id);
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Payment verification failed.');
        }

        // If payment is not successful, return error
        if ($session->payment_status !== 'paid') {
            return redirect()->route('checkout')->with('error', 'Payment not completed.');
        }

        $initials = strtoupper(substr($validatedData['first_name'], 0, 1) . substr($validatedData['last_name'], 0, 1));
        $orderDate = Carbon::now()->format('Ymd');
        $lastThreeDigits = substr($validatedData['phone'], -3);
        $orderID = $initials . $orderDate . $lastThreeDigits;

        $referenceCode = 'ORD-' . strtoupper(Str::random(4)) . '-' . now()->format('YmdHis');

        // Insert Order into Database
        $order = Order::create([
            'order_id' => $orderID,
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'postcode' => $validatedData['postcode'],
            'reference_code' => $referenceCode,
            'status' => 'Paid',
        ]);

        $orderItems = [];

        // Insert products into order_items table
        foreach ($validatedData['cart'] as $product) {
            $orderItems[] = OrderItem::create([
                'order_id' => uniqid(),
             
                'order_unique' => $order->order_id,
                'product_name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'size' => $product['size'] ?? null,
                'custom_name' => $product['custom_name'] ?? null,
                'custom_number' => $product['custom_number'] ?? null,
            ]);
        }

        // Send Email Notification to Customer
        Mail::to($validatedData['email'])->send(new OrderConfirmationMail($order, $orderItems));

        // Send Email Notification to Shop Owner
        $shopOwnerEmail = "suppliers@cobrapparel.com"; 
        // $shopOwnerEmail = "markantonyvc01@gmail.com"; 
        Mail::to($shopOwnerEmail)->send(new ShopOwnerNotificationMail($order, $orderItems));

        // Redirect to Thank You Page
        return redirect()->route('ty')->with('success', 'Payment successful. Your order has been placed.');
    }

}
