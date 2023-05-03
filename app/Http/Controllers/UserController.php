<?php

namespace App\Http\Controllers;
use App\Models\User;


use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function update(Request $request, User $user)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        // Include other fields as necessary
    ]);

    // Update the user
    $user->name = $request->name;
    $user->email = $request->email;
    // Update other fields as necessary

    $user->save();

    // Return a response
    return response()->json(['message' => 'Profile updated successfully']);
}

}
