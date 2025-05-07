<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Services\Interfaces\TagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class TagController extends Controller
{
    protected $tagService;
    
    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('check.permission:create_tags')->only(['create', 'store']);
        $this->middleware('check.permission:edit_tags')->only(['edit', 'update']);
        $this->middleware('check.permission:delete_tags')->only(['destroy']);
    }
    
    
    public function index()
    {
        $tags = $this->tagService->getAllTagsAlpha();
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        $data = $request->validated();
        $tag = $this->tagService->createTag($data);
        return redirect()->route('tags.show', $tag->id)
            ->with('success', 'Le tag a été créé avec succès!');
    }

    public function show(Tag $tag)
    {
        $posts = $this->tagService->getPostsWithTag($tag->id, 15);
        return view('tags.show', compact('tag', 'posts'));
    }

    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);
        return view('tags.edit', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $this->tagService->updateTag($tag->id, $data);
        return redirect()->route('tags.show', $tag->id)
            ->with('success', 'Le tag a été mis à jour avec succès!');
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $this->tagService->deleteTag($tag->id);
        return redirect()->route('tags.index')
            ->with('success', 'Le tag a été supprimé avec succès!');
    }
    
    public function populaires()
    {
        $tags = $this->tagService->getTagsPopulaires(20);
        return view('tags.populaires', compact('tags'));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        
        // Recherche simple - dans un vrai projet, créer une méthode dans le repository
        $tags = Tag::where('title', 'like', "%{$keyword}%")
                   ->orWhere('description', 'like', "%{$keyword}%")
                   ->get();
        
        return view('tags.search', compact('tags', 'keyword'));
    }
}
