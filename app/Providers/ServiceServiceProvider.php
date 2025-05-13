<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Interfaces\SavePostServiceInterface;
use App\Services\Interfaces\ReportTypeServiceInterface;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\ThreadServiceInterface;
use App\Services\Interfaces\BadgeServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\StatisticsServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\PollServiceInterface;


use App\Services\PermissionService;
use App\Services\RoleService;
use App\Services\BadgeService;
use App\Services\CommentService;
use App\Services\UserService;
use App\Services\PostService;
use App\Services\CommunityService;
use App\Services\PollService;
use App\Services\TagService;
use App\Services\ReportService;
use App\Services\ReportTypeService;
use App\Services\StatisticsService;
use App\Services\ThreadService;
use App\Services\SavePostService;


class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BadgeServiceInterface::class, BadgeService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(CommunityServiceInterface::class, CommunityService::class);
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
        $this->app->bind(StatisticsServiceInterface::class, StatisticsService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
        $this->app->bind(ThreadServiceInterface::class, ThreadService::class);
        $this->app->bind(SavePostServiceInterface::class, SavePostService::class);
        $this->app->bind(ReportTypeServiceInterface::class, ReportTypeService::class);
        $this->app->bind(PollServiceInterface::class, PollService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);

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
