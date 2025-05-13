<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReportTypeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/test-pagination', function() {
    $posts = Post::orderBy('created_at', 'desc')->paginate(10);
    return view('test-pagination', ['posts' => $posts]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');


require __DIR__.'/auth.php';


Route::middleware('create_post')->get('/create-new-post', [PostController::class, 'create'])->name('posts.create.direct');


Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/communities/search', [CommunityController::class, 'search'])->name('communities.search');
Route::get('/communities/{community}', [CommunityController::class, 'show'])->name('communities.show');


Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/populaires', [TagController::class, 'populaires'])->name('tags.populaires');
Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');


Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/search', [ThreadController::class, 'search'])->name('threads.search');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/communities/{community}/threads', [ThreadController::class, 'byCommunity'])->name('threads.by_community');


Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('check.role:User')
    ->name('dashboard');

    Route::get('/report/post/{post}', [App\Http\Controllers\ReportController::class, 'createForPost'])->name('reports.post.create');
    Route::get('/report/comment/{comment}', [App\Http\Controllers\ReportController::class, 'createForComment'])->name('reports.comment.create');
    Route::get('/report/community/{community}', [App\Http\Controllers\ReportController::class, 'createForCommunity'])->name('reports.community.create');
    Route::post('/reports', [App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
    Route::post('/reports/ajax', [App\Http\Controllers\ReportController::class, 'ajaxReport'])->name('reports.ajax');


    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::put('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'avatarUpdate'])->name('profile.avatar.update');
    Route::get('/profile/badges', [App\Http\Controllers\ProfileController::class, 'badges'])->name('profile.badges');
    Route::get('/profile/communities', [App\Http\Controllers\ProfileController::class, 'communities'])->name('profile.communities');
    Route::get('/profile/saved-posts', [App\Http\Controllers\ProfileController::class, 'savedPosts'])->name('profile.saved-posts');
    Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
    
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
    Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');
    Route::delete('/posts/{post}/unsave', [PostController::class, 'unsave'])->name('posts.unsave');
    


    Route::get('/communities/create', [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::get('/communities/{community}/edit', [CommunityController::class, 'edit'])->name('communities.edit');
    Route::put('/communities/{community}', [CommunityController::class, 'update'])->name('communities.update');
    Route::delete('/communities/{community}', [CommunityController::class, 'destroy'])->name('communities.destroy');
    Route::post('/communities/{community}/follow', [CommunityController::class, 'follow'])->name('communities.follow');
    Route::delete('/communities/{community}/unfollow', [CommunityController::class, 'unfollow'])->name('communities.unfollow');
    



    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/threads/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');



    Route::get('/saved-posts', [SavePostController::class, 'index'])->name('saved-posts.index');
    Route::post('/saved-posts', [SavePostController::class, 'store'])->name('saved-posts.store');
    Route::delete('/saved-posts/{savePost}', [SavePostController::class, 'destroy'])->name('saved-posts.destroy');



    Route::resource('polls', PollController::class, ['except' => ['edit', 'update', 'destroy']]);
    Route::post('/polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');
    Route::get('/polls/{poll}/results', [PollController::class, 'results'])->name('polls.results');


    Route::resource('comments', CommentController::class, ['except' => ['create']]);
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::get('/posts/{post}/comments', [CommentController::class, 'byPost'])->name('comments.by_post');

});


Route::middleware(['auth', 'check.permission:create_tags'])->group(function () {
    Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
});

Route::middleware(['auth', 'check.permission:edit_tags'])->group(function () {
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
});

Route::middleware(['auth', 'check.permission:delete_tags'])->group(function () {
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
});



Route::middleware(['auth', 'check.role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminTempController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [App\Http\Controllers\Admin\AdminDashboardController::class, 'statistics'])->name('statistics');
    
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::put('/profile/avatar', [App\Http\Controllers\Admin\ProfileController::class, 'avatarUpdate'])->name('profile.avatar.update');
    
    Route::get('/users', [App\Http\Controllers\Admin\AdminDashboardController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminDashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'deleteUser'])->name('users.delete');
    
    Route::get('/communities', [App\Http\Controllers\Admin\AdminDashboardController::class, 'communities'])->name('communities.index');
    Route::get('/communities/{community}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'showCommunity'])->name('communities.show');
    Route::get('/communities/{community}/edit', [App\Http\Controllers\Admin\AdminDashboardController::class, 'editCommunity'])->name('communities.edit');
    Route::put('/communities/{community}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'updateCommunity'])->name('communities.update');
    
    Route::get('/badges', [App\Http\Controllers\Admin\AdminDashboardController::class, 'badges'])->name('badges.index');
    Route::get('/badges/create', [App\Http\Controllers\Admin\AdminDashboardController::class, 'createBadge'])->name('badges.create');
    Route::post('/badges', [App\Http\Controllers\Admin\AdminDashboardController::class, 'storeBadge'])->name('badges.store');
    Route::get('/badges/{badge}/edit', [App\Http\Controllers\Admin\AdminDashboardController::class, 'editBadge'])->name('badges.edit');
    Route::put('/badges/{badge}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'updateBadge'])->name('badges.update');
    Route::delete('/badges/{badge}', [App\Http\Controllers\Admin\AdminDashboardController::class, 'deleteBadge'])->name('badges.delete');
    
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::resource('permissions', PermissionController::class);
    
    Route::resource('report-types', ReportTypeController::class);
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/handle', [ReportController::class, 'handle'])->name('reports.handle');
    Route::get('/reports-statistics', [ReportController::class, 'statistics'])->name('reports.statistics');
});


Route::middleware(['auth', 'check.role:Moderateur'])->prefix('moderateur')->name('moderateur.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Moderateur\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/communities', [App\Http\Controllers\Moderateur\DashboardController::class, 'communities'])->name('communities');
    
    Route::get('/communities/create', [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::get('/communities/{community}', [App\Http\Controllers\Moderateur\CommunityController::class, 'show'])->name('communities.show');
    Route::get('/communities/{community}/edit', [CommunityController::class, 'edit'])->name('communities.edit');
    Route::put('/communities/{community}', [CommunityController::class, 'update'])->name('communities.update');
    
    Route::get('/communities/{community}/members', [App\Http\Controllers\Moderateur\DashboardController::class, 'communityMembers'])->name('community.members');
    Route::get('/communities/{community}/stats', [App\Http\Controllers\Moderateur\DashboardController::class, 'communityStats'])->name('community.stats');
    Route::post('/communities/{community}/ban-user', [App\Http\Controllers\Moderateur\DashboardController::class, 'banUser'])->name('community.ban-user');
    
    Route::get('/reports', [App\Http\Controllers\Moderateur\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [App\Http\Controllers\Moderateur\ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/handle', [App\Http\Controllers\Moderateur\ReportController::class, 'handle'])->name('reports.handle');
    
    Route::get('/reported-posts', [App\Http\Controllers\Moderateur\ReportController::class, 'posts'])->name('reports.posts');
    Route::get('/reported-comments', [App\Http\Controllers\Moderateur\ReportController::class, 'comments'])->name('reports.comments');
    Route::get('/reported-communities', [App\Http\Controllers\Moderateur\ReportController::class, 'communities'])->name('reports.communities');
    
    Route::get('/posts/{post}', [App\Http\Controllers\Moderateur\PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [App\Http\Controllers\Moderateur\PostController::class, 'destroy'])->name('posts.destroy');
    
    Route::get('/statistics', [App\Http\Controllers\Moderateur\StatisticsController::class, 'index'])->name('statistics');
    
    Route::get('/profile', [App\Http\Controllers\Moderateur\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Moderateur\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Moderateur\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/avatar', [App\Http\Controllers\Moderateur\ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::put('/profile/avatar', [App\Http\Controllers\Moderateur\ProfileController::class, 'avatarUpdate'])->name('profile.avatar.update');
});

Route::redirect('/moderator', '/moderateur/dashboard');
Route::redirect('/moderator/dashboard', '/moderateur/dashboard');
Route::redirect('/moderator/communities', '/moderateur/communities');
Route::redirect('/moderator/communities/create', '/moderateur/communities/create');
Route::redirect('/moderator/reports', '/moderateur/reports');
Route::redirect('/moderator/profile', '/moderateur/profile');
Route::redirect('/moderator/profile/edit', '/moderateur/profile/edit');
Route::redirect('/moderator/profile/avatar', '/moderateur/profile/avatar');