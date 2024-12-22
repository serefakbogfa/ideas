<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;

class NotificationControllerTest extends TestCase
{
    use WithFaker;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );
    }

    public function test_user_can_get_notifications()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/notifications");

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Notifications retrieved successfully'
                ]);
    }

    public function test_user_can_mark_notification_as_read()
    {
        Sanctum::actingAs($this->user);

        $notification = Notification::create([
            'type' => 'retweet',
            'notifiable_type' => User::class,
            'notifiable_id' => $this->user->id,
            'data' => json_encode(['message' => 'Someone retweeted your tweet']),
            'read_at' => null
        ]);

        $response = $this->putJson("/api/notifications/{$notification->id}/read");

        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Notification marked as read'
                ]);
    }
} 