<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        return response()->json(Shop::all());
    }

 public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'owner' => 'required|string|max:255',
        'contact_name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'email' => 'required|string|email|max:255', // Ensure email validation
        'duration' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Store image
   $imagePath = 'shop_images/' . time() . '_' . $request->file('image')->getClientOriginalName();
    $request->file('image')->move(public_path('shop_images'), $imagePath);


    // Insert into database
    $shop = Shop::create([
        'name' => $request->name,
        'owner' => $request->owner,
        'contact_name' => $request->contact_name,
        'contact_number' => $request->contact_number,
        'emailAddress' => $request->email, // Use correct field name
        'duration' => $request->duration,
        'image' => $imagePath,
    ]);

    return response()->json(['message' => 'Shop added successfully!', 'shop' => $shop]);
}



    public function update(Request $request, $id)
    {
        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->owner = $request->owner;

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $shop->image);
            $shop->image = $request->file('image')->store('shop_images', 'public');
        }

        $shop->save();
        return response()->json(['message' => 'Shop updated successfully!', 'shop' => $shop]);
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        Storage::delete('public/' . $shop->image);
        $shop->delete();

        return response()->json(['message' => 'Shop deleted successfully!']);
    }

    public function showProducts($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        return view('products', compact('shop'));
    }
}
