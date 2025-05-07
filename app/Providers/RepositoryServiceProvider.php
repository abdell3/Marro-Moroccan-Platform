<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
        
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        
        $this->app->bind(
            PostServiceInterface::class,
            PostService::class
        );
        
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
        
        $this->app->bind(
            TagServiceInterface::class,
            TagService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
