<?php

namespace App\Http\Controllers;
use App\Models\CategoryRequest;



use Illuminate\Http\Request;

class CategoryRequestController extends Controller
{

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $categoryRequest = new CategoryRequest;
    $categoryRequest->name = $request->input('name');
    $categoryRequest->user_id = auth()->id();
    $categoryRequest->save();

    return response()->json([
        'message' => 'Category request submitted successfully!',
        'category_request' => $categoryRequest,
    ], 201);
    }

    public function index()
    {
        $user = auth()->user();
    
        if ($user->role === 'admin') {
            // If the user is an admin, return all category requests
            $categoryRequests = CategoryRequest::with('user')->get();
        } else {
            // If the user is not an admin, return only their category requests
            $categoryRequests = CategoryRequest::with('user')->where('user_id', $user->id)->get();
        }
    
        return response()->json($categoryRequests);
    }
    
    public function approve(Request $request, $id)
    {

        // Find the category request by ID
        $categoryRequest = CategoryRequest::findOrFail($id);
    
        // Update the status to 'approved'
        $categoryRequest->status = 'approved';
        $categoryRequest->save();
    
        return response()->json([
            'message' => 'Category request approved successfully!',
            'category_request' => $categoryRequest,
        ], 200);
    }
    
    public function deny(Request $request, $id)
    {

    
        // Find the category request by ID
        $categoryRequest = CategoryRequest::findOrFail($id);
    
        // Update the status to 'denied'
        $categoryRequest->status = 'denied';
        $categoryRequest->save();
    
        return response()->json([
            'message' => 'Category request denied successfully!',
            'category_request' => $categoryRequest,
        ], 200);
    }
    public function userRequests($userId)
    {
        $user = auth()->user();
        $categoryRequests = CategoryRequest::with('user')->where('user_id', $user->id)->get();
        return response()->json($categoryRequests);
    }


}
