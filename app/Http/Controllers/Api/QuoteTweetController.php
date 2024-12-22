<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\QuoteTweet;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/**
 * @group Quote Tweet Management
 *
 * APIs for managing quote tweets
 */
class QuoteTweetController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Create a quote tweet
     *
     * @urlParam idea required The ID of the idea to quote. Example: 1
     * @bodyParam content string required The content of the quote tweet. Example: This is a great idea!
     *
     * @response 201 {
     *  "status": "success",
     *  "message": "Quote tweet created successfully",
     *  "data": {
     *    "id": 1,
     *    "user_id": 1,
     *    "idea_id": 1,
     *    "content": "This is a great idea!",
     *    "created_at": "2024-12-22T15:00:00.000000Z",
     *    "updated_at": "2024-12-22T15:00:00.000000Z"
     *  }
     * }
     */
    public function store(Request $request, Idea $idea)
    {
        $request->validate([
            'content' => 'required|string|max:280'
        ]);

        $quoteTweet = QuoteTweet::create([
            'user_id' => auth()->id(),
            'idea_id' => $idea->id,
            'content' => $request->content
        ]);

        // Cache'i temizle
        Cache::tags(['ideas', 'quotes'])->forget("idea:{$idea->id}");
        Cache::tags(['user', 'quotes'])->forget("user:{$idea->user_id}:quotes");
        Cache::tags(['user', 'quotes'])->forget("user:" . auth()->id() . ":quotes");

        return $this->successResponse($quoteTweet, 'Quote tweet created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
