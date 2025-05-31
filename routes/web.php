<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Models\User; // Ensure User model exists
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/place-order', [OrderController::class, 'placeOrder']); // Route to place order
// Route::post('/register-user', [RegisterController::class, 'register']);
Route::post('/register-user', function () {
    return response()->json(['message' => 'This is a placeholder for user registration.']);
});

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    dd("clear");
});

require __DIR__ . '/auth.php';
