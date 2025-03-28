<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;

use Stripe\Exception\ApiErrorException;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\RedirectResponse;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class CheckoutController extends Controller
{
    
public function checkout(): View|Factory|Application
    {
        return view('charge');
    }

public function success(): View|Factory|Application
    {
        return view('success');
    }

public function store(Request $request)
{
    // Validate form data
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'address' => 'required|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'postcode' => 'required|string|max:10',
        'cart' => 'required|array',
    ]);

    try {
        Stripe::setApiKey(config('stripe.test.sk'));

        // Store data in session
        session(['checkout_data' => $validatedData]);

        // Prepare line items for Stripe Checkout
        $lineItems = [];
        $totalAmount = 0; // Initialize total in cents

        foreach ($validatedData['cart'] as $product) {
            $unitAmount = $product['price'] * 1.10 * 100; // Include GST (10%) and convert to cents
            $totalAmount += $unitAmount * $product['quantity']; // Compute total

            $productDescription = "Size: " . ($product['size'] ?? 'N/A') . 
                      ", Custom Name: " . ($product['custom_name'] ?? 'N/A') . 
                      ", Custom Number: " . ($product['custom_number'] ?? 'N/A');

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => $product['name'],
                        'description' => $productDescription,
                    ],
                    'unit_amount' => round($unitAmount), // Round to avoid Stripe errors
                ],
                'quantity' => $product['quantity'],
            ];
        }

        // Create Stripe Checkout Session
        $session = Session::create([
            'line_items'  => $lineItems,
            'mode'        => 'payment',
            'success_url' => route('confirm') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('charge'),
        ]);

        // Return checkout URL to frontend
        return response()->json(['checkout_url' => $session->url]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function show($id)
    {
        // Fetch the order based on order_id
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

    
        $orderItems = OrderItem::where('order_unique', $order->order_id)->get();

        return response()->json([
            'order_id' => $order->order_id,
            'customer' => $order->first_name . ' ' . $order->last_name,
            'status' => $order->status, 
            'date' => $order->created_at->format('Y-m-d'),
            'items' => $orderItems
        ]);
    }

   public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get(); // Order by oldest first
        return view('admin.orders', compact('orders'));
    }


    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('order_id', $id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:Paid,Pending,In Production,Completed',
        ]);

        // $order->update(['status' => $request->status]);
        $order->status = $request->status;
        $order->save();


        return response()->json(['message' => 'Status updated successfully!', 'status' => $order->status]);
    }


}
