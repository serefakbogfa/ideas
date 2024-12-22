<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Idea;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_get_all_ideas()
    {
        $user = User::factory()->create();
        $ideas = Idea::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($this->user)
                        ->getJson('/api/ideas');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data');
    }

    public function test_can_create_idea()
    {
        $ideaData = [
            'content' => 'Test idea content',
            'user_id' => $this->user->id,
            'likes_count' => 0
        ];

        $response = $this->actingAs($this->user)
                        ->postJson('/api/ideas', $ideaData);

        $response->assertStatus(201)
                ->assertJsonFragment(['content' => 'Test idea content']);

        $this->assertDatabaseHas('ideas', [
            'content' => 'Test idea content',
            'user_id' => $this->user->id,
            'likes_count' => 0
        ]);
    }

    public function test_can_update_idea()
    {
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
            'likes_count' => 0
        ]);

        $response = $this->actingAs($this->user)
                        ->putJson("/api/ideas/{$idea->id}", [
                            'content' => 'Updated content'
                        ]);

        $response->assertStatus(200)
                ->assertJsonFragment(['content' => 'Updated content']);
    }

    public function test_can_delete_idea()
    {
        $idea = Idea::factory()->create([
            'user_id' => $this->user->id,
            'likes_count' => 0
        ]);

        $response = $this->actingAs($this->user)
                        ->deleteJson("/api/ideas/{$idea->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
    }
}
