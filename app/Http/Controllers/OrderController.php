<?php

namespace App\Http\Controllers;

use App\Models\User; // Assuming you have a User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessOrder;
use App\Jobs\SendOrderConfirmationEmail;
use App\Jobs\UpdateInventory;
use App\Events\OrderPlaced; // Import our new event

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // --- Simulate order creation logic ---
        $user = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            ['name' => 'Test Customer', 'password' => bcrypt('password')]
        );
        $orderId = rand(10000, 99999); // Simulate an order ID
        Log::info("Order ID: {$orderId} placed by user: {$user->email}.");
        // --- End order creation logic ---

        // Dispatch the job to the queue
        // This pushes the job onto the 'jobs' table, and the HTTP request continues immediately.
        SendOrderConfirmationEmail::dispatch($user, $orderId);

        // Dispatch the OrderPlaced event
        // The ProcessOrderPlaced listener (which is queued) will then handle this.
        OrderPlaced::dispatch($orderId, $user->id);

        // ... in your controller or service
        // \Illuminate\Support\Facades\Bus::chain([
        //     new ProcessOrder($orderId),
        //     new SendOrderConfirmationEmail($user, $orderId),
        //     new UpdateInventory($orderId),
        // ])->dispatch();

        // You can also dispatch synchronously (not recommended for long tasks)
        // SendOrderConfirmationEmail::dispatchSync($user, $orderId);

        // Or delay the job
        // SendOrderConfirmationEmail::dispatch($user, $orderId)->delay(now()->addMinutes(5));

        return response()->json(['message' => 'Order placed successfully! Email confirmation will be sent shortly.']);
    }
}
