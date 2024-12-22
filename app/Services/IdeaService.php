<?php

namespace App\Services;

use App\Repositories\IdeaRepository;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\IdeaNotFoundException;

class IdeaService
{
    protected $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    public function getAllIdeas()
    {
        return Cache::remember('ideas.all', 3600, function () {
            return $this->ideaRepository->all();
        });
    }

    public function createIdea(array $data)
    {
        Cache::forget('ideas.all'); // Cache'i temizle
        return $this->ideaRepository->create($data);
    }

    public function getIdea($id)
    {
        return Cache::remember("ideas.{$id}", 3600, function () use ($id) {
            try {
                return $this->ideaRepository->findById($id);
            } catch (\Exception $e) {
                throw new IdeaNotFoundException("İçerik #{$id} bulunamadı.");
            }
        });
    }

    public function updateIdea($id, array $data)
    {
        Cache::forget("ideas.{$id}"); // Tekil cache'i temizle
        Cache::forget('ideas.all'); // Tüm liste cache'ini temizle
        return $this->ideaRepository->update($id, $data);
    }

    public function deleteIdea($id)
    {
        Cache::forget("ideas.{$id}");
        Cache::forget('ideas.all');
        return $this->ideaRepository->delete($id);
    }
} 