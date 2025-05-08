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



Route::get('/', [HomeController::class, 'index'])->name('home');


require __DIR__.'/auth.php';


Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
Route::get('/communities/{community}', [CommunityController::class, 'show'])->name('communities.show');
Route::get('/communities/search', [CommunityController::class, 'search'])->name('communities.search');


Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('/tags/populaires', [TagController::class, 'populaires'])->name('tags.populaires');
Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');


Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::get('/threads/search', [ThreadController::class, 'search'])->name('threads.search');
Route::get('/communities/{community}/threads', [ThreadController::class, 'byCommunity'])->name('threads.by_community');


Route::middleware('auth')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');



    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::put('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'avatarUpdate'])->name('profile.avatar.update');
    Route::get('/profile/communities', [App\Http\Controllers\ProfileController::class, 'communities'])->name('profile.communities');
    Route::get('/profile/saved-posts', [App\Http\Controllers\ProfileController::class, 'savedPosts'])->name('profile.saved-posts');
    Route::get('/profile/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('profile.settings');
    
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
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

});


Route::middleware(['auth', 'role:Moderateur'])->prefix('moderator')->name('moderator.')->group(function () {
    Route::get('/dashboard', function () {
        return view('moderator.dashboard');
    })->name('dashboard');
    
    Route::get('/reported-posts', function () {
        return view('moderator.reported-posts');
    })->name('reported-posts');
    
    Route::get('/reported-comments', function () {
        return view('moderator.reported-comments');
    })->name('reported-comments');
});
