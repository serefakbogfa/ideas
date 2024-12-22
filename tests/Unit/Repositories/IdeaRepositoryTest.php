<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Repositories\IdeaRepository;
use App\Models\Idea;
use App\Models\User;
use App\Exceptions\IdeaNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdeaRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new IdeaRepository();
        $this->user = User::factory()->create();
    }

    public function test_can_get_all_ideas()
    {
        Idea::factory()->count(3)->create();

        $ideas = $this->repository->all();

        $this->assertCount(3, $ideas);
    }

    public function test_can_create_idea()
    {
        $data = [
            'content' => 'Test content',
            'user_id' => $this->user->id
        ];

        $idea = $this->repository->create($data);

        $this->assertInstanceOf(Idea::class, $idea);
        $this->assertEquals('Test content', $idea->content);
        $this->assertEquals($this->user->id, $idea->user_id);
    }

    public function test_can_find_idea_by_id()
    {
        $createdIdea = Idea::factory()->create();

        $foundIdea = $this->repository->findById($createdIdea->id);

        $this->assertInstanceOf(Idea::class, $foundIdea);
        $this->assertEquals($createdIdea->id, $foundIdea->id);
    }

    public function test_throws_exception_when_idea_not_found()
    {
        $this->expectException(IdeaNotFoundException::class);

        $this->repository->findById(999);
    }

    public function test_can_update_idea()
    {
        $idea = Idea::factory()->create();
        $newData = ['content' => 'Updated content'];

        $updatedIdea = $this->repository->update($idea->id, $newData);

        $this->assertEquals('Updated content', $updatedIdea->content);
    }

    public function test_can_delete_idea()
    {
        $idea = Idea::factory()->create();

        $result = $this->repository->delete($idea->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('ideas', ['id' => $idea->id]);
    }
} 