<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\IdeaRepository;
use App\Services\IdeaService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(IdeaRepository::class, function ($app) {
            return new IdeaRepository();
        });

        $this->app->bind(IdeaService::class, function ($app) {
            return new IdeaService($app->make(IdeaRepository::class));
        });
    }
}
