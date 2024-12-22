<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;

class MediaControllerTest extends TestCase
{
    use WithFaker;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        
        Storage::fake('public');
        
        $this->user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );
    }

    public function test_user_can_upload_image()
    {
        Sanctum::actingAs($this->user);

        $file = UploadedFile::fake()->image('test.jpg');

        $response = $this->postJson('/api/media/upload', [
            'file' => $file
        ]);

        $response->assertStatus(201)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'File uploaded successfully'
                ]);

        $this->assertTrue(Storage::disk('public')->exists('media/' . $file->hashName()));
    }

    public function test_user_cannot_upload_invalid_file()
    {
        Sanctum::actingAs($this->user);

        $file = UploadedFile::fake()->create('document.pdf', 1000);

        $response = $this->postJson('/api/media/upload', [
            'file' => $file
        ]);

        $response->assertStatus(422);
    }
} 