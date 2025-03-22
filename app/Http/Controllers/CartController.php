<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    public function addToCart(Request $request)
{
    // Decode JSON data from request
    $data = json_decode($request->getContent(), true);

    if (!$data) {
        return response()->json(['error' => 'Invalid JSON data'], 400);
    }

    // Validate request data
    $validatedData = validator($data, [
        'id' => 'required|integer',
        'name' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'quantity' => 'required|integer',
        'size' => 'nullable|string',
        'color' => 'nullable|string',
        'custom_name' => 'nullable|string|max:255',
        'custom_number' => 'nullable|string|max:255',
    ])->validate();

    if ($request->hasFile('image')) {
                    // Store in storage/app/public/news_images
                    $imagePath = $request->file('image')->store('shop_images', 'public');

                    // Copy the file to public/storage/news_images
                    $sourcePath = storage_path("app/public/{$imagePath}");
                    $destinationPath = public_path("storage/{$imagePath}");
                    copy($sourcePath, $destinationPath);
                }


    // Store in database
    $cartItem = CartItem::create([
        'product_id' => $validatedData['id'],
        'name' => $validatedData['name'],
        'price' => $validatedData['price'],
        'image' => $imagePath,
        'quantity' => $validatedData['quantity'],
        'size' => $validatedData['size'] ?? null,
        'color' => $validatedData['color'] ?? null,
        'custom_name' => $validatedData['custom_name'] ?? null,
        'custom_number' => $validatedData['custom_number'] ?? null,
    ]);

    return response()->json(['message' => 'Item added to cart', 'cartItem' => $cartItem], 201);
}


    public function getCartItems()
    {
        $cartItems = CartItem::all()->map(function ($item) {
            $item->price = (float) $item->price; // Ensure price is a float
            return $item;
        });

        return response()->json($cartItems);
    }


public function removeFromCart($id)
{
    $cartItem = CartItem::find($id);

    if (!$cartItem) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    $cartItem->delete();
    return response()->json(['message' => 'Item removed from cart']);
}

public function updateCartItem(Request $request)
{
    $data = $request->validate([
        'id' => 'required|integer',
        'quantity' => 'required|integer|min:1'
    ]);

    $cartItem = CartItem::find($data['id']);

    if (!$cartItem) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    $cartItem->update(['quantity' => $data['quantity']]);
    return response()->json(['message' => 'Quantity updated']);
}




}

