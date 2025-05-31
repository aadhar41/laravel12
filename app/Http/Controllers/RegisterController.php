<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Events\UserRegistered; // Import our custom event
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Dispatch the UserRegistered event
        // All registered listeners will be called. Queued listeners will go to the queue.
        UserRegistered::dispatch($user);
        // Alternative: event(new UserRegistered($user));

        Log::info(__METHOD__ . " Controller: User {$user->email} registered successfully.");

        return response()->json(['message' => 'User registered successfully! Welcome email will be sent shortly.']);
    }
}