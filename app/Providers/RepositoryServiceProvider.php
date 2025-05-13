<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Repositories\Interfaces\ThreadRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\PollRepositoryInterface;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;
use App\Repositories\Interfaces\SavePostRepositoryInterface;


use App\Repositories\RoleRepository;
use App\Repositories\BadgeRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;
use App\Repositories\CommunityRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PollRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReportTypeRepository;
use App\Repositories\SavePostRepository;
use App\Repositories\TagRepository;
use App\Repositories\ThreadRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BadgeRepositoryInterface::class, BadgeRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommunityRepositoryInterface::class, CommunityRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ThreadRepositoryInterface::class, ThreadRepository::class);
        $this->app->bind(SavePostRepositoryInterface::class, SavePostRepository::class);
        $this->app->bind(ReportTypeRepositoryInterface::class, ReportTypeRepository::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
        $this->app->bind(PollRepositoryInterface::class, PollRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);

        







    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
