<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/products', [ProductController::class, 'list'])->name('products');
Route::middleware([
    'guestOrVerified',
])->group(function () {
    Route::prefix('/cart')->name('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('.index');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('.remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('.update-quantity');
    });
    Route::post('/order', [CartController::class, 'updateQuantity'])->name('order');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/admin/products', ProductController::class);
});


// Route::view('/{any}', function () {
//     return Inertia::render('NotFound');
// })->where('any', '.*');
Route::view('/{any}', 'notfound')->where('any', '.*');
