<?php

namespace App\Http\Controllers;

use App\Models\SavePost;
use App\Http\Requests\StoreSavePostRequest;
use App\Http\Requests\UpdateSavePostRequest;
use App\Services\Interfaces\SavePostServiceInterface;
use Illuminate\Routing\Controller;

class SavePostController extends Controller
{
    protected $savePostService;

    public function __construct(SavePostServiceInterface $savePostService)
    {
        $this->savePostService = $savePostService;
        $this->authorizeResource(SavePost::class, 'savePost');
    }

    public function index()
    {
        $savedPosts = $this->savePostService->getUserSavedPosts();
        return view('save_posts.index', compact('savedPosts'));
    }

    public function store(StoreSavePostRequest $request)
    {
        $validated = $request->validated();
        $result = $this->savePostService->savePost(
            $validated['post_id'],
            $validated['user_id'] ?? null
        );

        if (!$result) {
            return redirect()->back()
                ->with('error', 'Impossible de sauvegarder ce post.');
        }

        return redirect()->back()
            ->with('success', 'Post sauvegardé avec succès!');
    }

    public function destroy(SavePost $savePost)
    {
        $result = $this->savePostService->unsavePost(
            $savePost->post_id,
            $savePost->user_id
        );
        if (!$result) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer ce post sauvegardé.');
        }
        return redirect()->back()
            ->with('success', 'Post retiré des favoris avec succès!');
    }
}
