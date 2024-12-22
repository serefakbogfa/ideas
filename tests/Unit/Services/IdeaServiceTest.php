<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\IdeaService;
use App\Repositories\IdeaRepository;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IdeaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $ideaService;
    protected $ideaRepository;

    public function setUp(): void
    {
        parent::setUp();
        /** @var IdeaRepository|\Mockery\MockInterface $ideaRepository */
        $this->ideaRepository = Mockery::mock(IdeaRepository::class);
        $this->ideaService = new IdeaService($this->ideaRepository);
    }

    public function test_get_all_ideas()
    {
        $this->ideaRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn(collect([]));

        $result = $this->ideaService->getAllIdeas();
        
        $this->assertIsObject($result);
    }

    public function test_create_idea()
    {
        $data = ['content' => 'Test content'];

        $this->ideaRepository
            ->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn((object)$data);

        $result = $this->ideaService->createIdea($data);
        
        $this->assertEquals('Test content', $result->content);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}