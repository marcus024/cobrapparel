<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmController;
use Stripe\Stripe;
use Stripe\PaymentIntent;


Route::get('/', function () {
    return view('shops');
});

Route::get('/orderconfirm', function () {
    return view('emails.order_confirmation');
});

Route::get('/shopnotif', function () {
    return view('emails.shop_notif');
});

Route::get('/login', function () {
    return view('login');
})->name('login');


Route::get('/product', function () {
    return view('products');
});

// Route::get('/addtc', function () {
//     return view('addtc');
// });
Route::get('/addtc/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('addtc', compact('product'));
});

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');


Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/admin/layouts/admin', function () {
    return view('admin.layouts.admin');
})->middleware('auth')->name('admin.admin');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/shops', 'admin.shops')->name('admin.shops');
    Route::view('/products', 'admin.products')->name('admin.products');
    Route::view('/orders', 'admin.orders')->name('admin.orders');
    Route::view('/export', 'admin.export')->name('admin.export');
    Route::get('/orders/{id}', [CheckoutController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders', [CheckoutController::class, 'index'])->name('admin.orders');

});

// Shop Controller
Route::get('/shops', [ShopController::class, 'index']);
Route::post('/shops', [ShopController::class, 'store']);
Route::post('/shops/{id}/update', [ShopController::class, 'update']);
Route::delete('/shops/{id}', [ShopController::class, 'destroy']);



Route::post('/products', [ProductController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);


Route::get('/products/{id}', [ProductController::class, 'showProducts']);

Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart/items', [CartController::class, 'getCartItems']);
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
Route::post('/cart/update', [CartController::class, 'updateCartItem']);

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::view('/thank-you', 'thankyou')->name('ty');

Route::get('/orders/{id}', [CheckoutController::class, 'show'])->name('admin.orders.show');
Route::put('/orders/{id}/status', [CheckoutController::class, 'updateStatus'])->name('admin.orders.updateStatus');

// Route::get('/charge', 'App\Http\Controllers\StripeController@checkout')->name('charge');
Route::post('/test', 'App\Http\Controllers\StripeController@test');
Route::post('/live', 'App\Http\Controllers\StripeController@live');
// Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');


Route::post('/testCheckout', 'App\Http\Controllers\CheckoutController@store');

Route::get('/charge', 'App\Http\Controllers\CheckoutController@checkout')->name('charge');
Route::get('/success', 'App\Http\Controllers\CheckoutController@checkout')->name('success');

Route::get('/success', [ConfirmController::class, 'success'])->name('confirm');
