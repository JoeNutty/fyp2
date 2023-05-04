<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Post;


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

public function index()
{
    $users = User::all(); // Fetch all users
    return response()->json($users); // Return them as JSON
}
public function show($id)
{
    $user = User::withCount('posts')->find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json($user);
}
public function destroy($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}
public function deletePosts($id)
{
    $user = User::findOrFail($id);

    // Delete all the user's posts
    $user->posts()->delete();

    return response()->json(null, 204);
}





}
