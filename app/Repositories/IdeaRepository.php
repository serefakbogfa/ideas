<?php

namespace App\Repositories;

use App\Models\Idea;
use App\Exceptions\IdeaNotFoundException;

class IdeaRepository
{
    public function all()
    {
        return Idea::with(['user', 'comments'])->latest()->paginate(10);
    }

    public function create(array $data)
    {
        return Idea::create($data);
    }

    public function findById($id)
    {
        $idea = Idea::with(['user', 'comments'])->find($id);
        
        if (!$idea) {
            throw new IdeaNotFoundException("İçerik #{$id} bulunamadı.");
        }
        
        return $idea;
    }

    public function update($id, array $data)
    {
        $idea = $this->findById($id);
        $idea->update($data);
        return $idea;
    }

    public function delete($id)
    {
        return $this->findById($id)->delete();
    }
} 