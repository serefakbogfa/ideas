<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\Retweet;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/**
 * @group Retweet Management
 *
 * APIs for managing retweets
 */
class RetweetController extends Controller
{
    use ApiResponse;

    /**
     * Retweet an idea
     *
     * @urlParam idea required The ID of the idea to retweet. Example: 1
     *
     * @response 201 {
     *  "status": "success",
     *  "message": "Retweeted successfully",
     *  "data": {
     *    "id": 1,
     *    "user_id": 1,
     *    "idea_id": 1,
     *    "created_at": "2024-12-22T15:00:00.000000Z",
     *    "updated_at": "2024-12-22T15:00:00.000000Z"
     *  }
     * }
     */
    public function retweet(Idea $idea)
    {
        $retweet = Retweet::create([
            'user_id' => auth()->id(),
            'idea_id' => $idea->id
        ]);

        // Cache'i temizle
        Cache::tags(['ideas', 'retweets'])->forget("idea:{$idea->id}");
        Cache::tags(['user', 'retweets'])->forget("user:{$idea->user_id}:retweets");

        return $this->successResponse($retweet, 'Retweeted successfully', 201);
    }

    /**
     * Remove a retweet
     *
     * @urlParam idea required The ID of the idea to unretweet. Example: 1
     *
     * @response {
     *  "status": "success",
     *  "message": "Unretweet successful"
     * }
     */
    public function unretweet(Idea $idea)
    {
        Retweet::where('user_id', auth()->id())
               ->where('idea_id', $idea->id)
               ->delete();

        // Cache'i temizle
        Cache::tags(['ideas', 'retweets'])->forget("idea:{$idea->id}");
        Cache::tags(['user', 'retweets'])->forget("user:{$idea->user_id}:retweets");

        return $this->successResponse(null, 'Unretweet successful');
    }
}
