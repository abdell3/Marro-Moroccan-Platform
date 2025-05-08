<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\CommunityRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PostRepository;
use App\Repositories\RoleRepository;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;
use App\Services\CommunityService;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use App\Services\Interfaces\ThreadServiceInterface;
use App\Services\PermissionService;
use App\Services\PostService;
use App\Services\RoleService;
use App\Services\TagService;
use App\Services\ThreadService;
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




        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
        $this->app->bind(
            PermissionServiceInterface::class,
            PermissionService::class
        );



        
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(
            RoleServiceInterface::class,
            RoleService::class
        );



        $this->app->bind(
            CommunityRepositoryInterface::class,
            CommunityRepository::class
        );
        $this->app->bind(
            CommunityServiceInterface::class,
            CommunityService::class
        );


        
        $this->app->bind(
            ThreadRepositoryInterface::class,
            ThreadRepository::class
        );
        $this->app->bind(
            ThreadServiceInterface::class,
            ThreadService::class
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
