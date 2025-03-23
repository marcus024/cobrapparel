<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shop;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('shop')->get();
        return response()->json($products);
    }

    public function store(Request $request)
{
    $request->validate([
        'shop_id'   => 'required|exists:shops,id',
        'name'      => 'required|string|max:255',
        'price'     => 'required|numeric|min:0',
        'stock'     => 'required|integer|min:0',
        'productEnd'=> 'nullable|string|max:255',
        'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
    ]);

    $imagePaths = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // Store in storage/app/public/products
            $imagePath = $image->store('products', 'public');

            // Define source and destination paths
            $sourcePath = storage_path("app/public/{$imagePath}");
            $destinationPath = public_path("storage/{$imagePath}");

            // Ensure the destination directory exists
            if (!file_exists(dirname($destinationPath))) {
                mkdir(dirname($destinationPath), 0755, true);
            }

            // Copy the file to public/storage/products
            copy($sourcePath, $destinationPath);

            // Store the public path for easy access
            $imagePaths[] = "storage/{$imagePath}";
        }
    }

    // Prepare product data
    $productData = [
        'shop_id'   => $request->shop_id,
        'name'      => $request->name,
        'price'     => $request->price,
        'stock'     => $request->stock,
        'productEnd'=> $request->productEnd,
        'images'    => json_encode($imagePaths), // Store images as JSON
    ];

    // Conditionally add optional fields if provided
    if ($request->filled('size_chart')) {
        $productData['size_chart'] = $request->size_chart;
    }
    if ($request->filled('custom_name')) {
        $productData['custom_name'] = $request->custom_name;
    }
    if ($request->filled('custom_number')) {
        $productData['custom_number'] = $request->custom_number;
    }

    Product::create($productData);

    return response()->json(['message' => 'Product added successfully'], 201);
}

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete all stored images
            if ($product->images) {
                $images = json_decode($product->images, true);
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting product', 'error' => $e->getMessage()], 500);
        }
    }

    public function showProducts($id)
    {
        $shop = Shop::findOrFail($id);
        $products = Product::where('shop_id', $id)->get();

        return view('products', compact('shop', 'products'));
    }
}
