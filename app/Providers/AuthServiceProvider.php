<?php

namespace App\Providers;

use App\Models\Badge;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Permission;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Report;
use App\Models\ReportType;
use App\Models\Role;
use App\Models\SavePost;
use App\Models\Tag;
use App\Models\Thread;
use App\Policies\BadgePolicy;
use App\Policies\CommentPolicy;
use App\Policies\CommunityPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PollPolicy;
use App\Policies\PostPolicy;
use App\Policies\ReportPolicy;
use App\Policies\ReportTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\SavePostPolicy;
use App\Policies\TagPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        SavePost::class => SavePostPolicy::class,
        Poll::class => PollPolicy::class,
        Post::class => PostPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Thread::class => ThreadPolicy::class,
        Tag::class => TagPolicy::class,
        Comment::class => CommentPolicy::class,
        Community::class => CommunityPolicy::class,
        Report::class => ReportPolicy::class,
        ReportType::class => ReportTypePolicy::class,
        Badge::class => BadgePolicy::class
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
