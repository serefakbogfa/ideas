<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Idea;
use App\Models\Retweet;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RetweetControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $idea;

    public function setUp(): void
    {
        parent::setUp();
        
        // Test kullanıcısı ve tweet oluştur
        $this->user = User::factory()->create();
        $this->idea = Idea::factory()->create();
    }

    public function test_user_can_retweet_an_idea()
    {
        // Kullanıcı girişi yap
        Sanctum::actingAs($this->user);

        // Retweet isteği gönder
        $response = $this->postJson("/api/ideas/{$this->idea->id}/retweet");

        // Assertion'lar
        $response->assertStatus(201)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Retweeted successfully'
                ]);

        // Veritabanı kontrolü
        $this->assertDatabaseHas('retweets', [
            'user_id' => $this->user->id,
            'idea_id' => $this->idea->id
        ]);
    }

    public function test_user_can_unretweet_an_idea()
    {
        // Önce retweet oluştur
        Sanctum::actingAs($this->user);
        Retweet::create([
            'user_id' => $this->user->id,
            'idea_id' => $this->idea->id
        ]);

        // Unretweet isteği gönder
        $response = $this->deleteJson("/api/ideas/{$this->idea->id}/unretweet");

        // Assertion'lar
        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Unretweet successful'
                ]);

        // Veritabanı kontrolü
        $this->assertDatabaseMissing('retweets', [
            'user_id' => $this->user->id,
            'idea_id' => $this->idea->id
        ]);
    }
}
