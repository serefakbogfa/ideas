<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Idea;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;

class QuoteTweetControllerTest extends TestCase
{
    use WithFaker;

    private $user;
    private $idea;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );
        
        $this->idea = Idea::firstOrCreate(
            ['content' => 'Test Tweet'],
            ['user_id' => $this->user->id]
        );
    }

    public function test_user_can_quote_tweet()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson("/api/ideas/{$this->idea->id}/quote", [
            'content' => $this->faker->sentence
        ]);

        $response->assertStatus(201)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Quote tweet created successfully'
                ]);
    }
} 