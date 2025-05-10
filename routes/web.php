<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

// Route de diagnostic pour la pagination
Route::get('/test-pagination', function() {
    $posts = \App\Models\Post::orderBy('created_at', 'desc')->paginate(10);
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
    ->name('dashboard');

    // Routes pour les rapports utilisateurs
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



Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->name('roles.permissions');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');
    Route::resource('permissions', PermissionController::class);
    
    // Routes pour la gestion des types de rapports
    Route::resource('report-types', Admin\ReportTypeController::class);
    
    // Routes pour la gestion des rapports
    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [Admin\ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/handle', [Admin\ReportController::class, 'handle'])->name('reports.handle');
    Route::get('/reports-statistics', [Admin\ReportController::class, 'statistics'])->name('reports.statistics');
});


Route::middleware(['auth', 'role:Moderateur'])->prefix('moderator')->name('moderator.')->group(function () {
    // Dashboard modérateur
    Route::get('/dashboard', [App\Http\Controllers\Moderateur\DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des communautés du modérateur
    Route::get('/communities', [App\Http\Controllers\Moderateur\DashboardController::class, 'communities'])->name('communities');
    Route::get('/communities/{community}/members', [App\Http\Controllers\Moderateur\DashboardController::class, 'communityMembers'])->name('community.members');
    Route::get('/communities/{community}/stats', [App\Http\Controllers\Moderateur\DashboardController::class, 'communityStats'])->name('community.stats');
    Route::post('/communities/{community}/ban-user', [App\Http\Controllers\Moderateur\DashboardController::class, 'banUser'])->name('community.ban-user');
    
    // Routes pour la gestion des rapports par les modérateurs
    Route::get('/reports', [App\Http\Controllers\Moderateur\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [App\Http\Controllers\Moderateur\ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/handle', [App\Http\Controllers\Moderateur\ReportController::class, 'handle'])->name('reports.handle');
    
    // Routes spécifiques par type de contenu
    Route::get('/reported-posts', [App\Http\Controllers\Moderateur\ReportController::class, 'posts'])->name('reports.posts');
    Route::get('/reported-comments', [App\Http\Controllers\Moderateur\ReportController::class, 'comments'])->name('reports.comments');
    Route::get('/reported-communities', [App\Http\Controllers\Moderateur\ReportController::class, 'communities'])->name('reports.communities');
});
