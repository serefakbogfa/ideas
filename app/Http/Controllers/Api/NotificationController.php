<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

/**
 * @group Notification Management
 *
 * APIs for managing notifications
 */
class NotificationController extends Controller
{
    use ApiResponse;

    /**
     * Get all notifications
     *
     * Returns a paginated list of notifications for the authenticated user
     *
     * @response {
     *  "status": "success",
     *  "message": "Notifications retrieved successfully",
     *  "data": {
     *    "current_page": 1,
     *    "data": [
     *      {
     *        "id": 1,
     *        "type": "retweet",
     *        "notifiable_type": "App\\Models\\User",
     *        "notifiable_id": 1,
     *        "data": {"message": "Someone retweeted your tweet"},
     *        "read_at": null,
     *        "created_at": "2024-12-22T15:00:00.000000Z",
     *        "updated_at": "2024-12-22T15:00:00.000000Z"
     *      }
     *    ],
     *    "first_page_url": "http://localhost/api/notifications?page=1",
     *    "from": 1,
     *    "last_page": 1,
     *    "per_page": 20
     *  }
     * }
     */
    public function index()
    {
        // Cache key oluştur
        $cacheKey = "user:" . auth()->id() . ":notifications";

        // Cache'den veriyi al veya yoksa veritabanından çek
        $notifications = Cache::tags(['user', 'notifications'])->remember($cacheKey, 3600, function () {
            return Notification::where('notifiable_id', auth()->id())
                ->where('notifiable_type', User::class)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        });

        return $this->successResponse($notifications, 'Notifications retrieved successfully');
    }

    /**
     * Mark a notification as read
     *
     * @urlParam notification required The ID of the notification. Example: 1
     *
     * @response {
     *  "status": "success",
     *  "message": "Notification marked as read"
     * }
     */
    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        // Cache'i temizle
        Cache::tags(['user', 'notifications'])->forget("user:" . auth()->id() . ":notifications");

        return $this->successResponse(null, 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        // Cache'i temizle
        Cache::tags(['user', 'notifications'])->forget("user:" . auth()->id() . ":notifications");

        return $this->successResponse(null, 'All notifications marked as read');
    }
}
