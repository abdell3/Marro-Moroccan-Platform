<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\ThreadServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    protected $threadService;
    protected $communityService;
    
    public function __construct(ThreadServiceInterface $threadService, CommunityServiceInterface $communityService) 
    {
        $this->threadService = $threadService;
        $this->communityService = $communityService;
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index()
    {
        $threads = $this->threadService->getLatestThreads(20);
        return view('threads.index', compact('threads'));
    }

    public function create(Request $request)
    {
        $communityId = $request->input('community_id');
        if ($communityId) {
            $community = $this->communityService->getCommunityById($communityId);
        } else {
            $community = null;
        }
        
        $communities = $this->communityService->getAllCommunitiesAlpha();
        
        return view('threads.create', compact('communities', 'community'));
    }

    public function store(StoreThreadRequest $request)
    {
        $data = $request->validated();
        $thread = $this->threadService->createThread($data);
        return redirect()->route('threads.show', $thread->id)
            ->with('success', 'Le thread a été créé avec succès!');
    }

    public function show(Thread $thread)
    {
        $thread = $this->threadService->getThreadWithDetails($thread->id);
        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        if (Auth::id() != $thread->user_id) {
            return redirect()->route('threads.show', $thread->id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier ce thread.');
        }
        return view('threads.edit', compact('thread'));
    }

    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        $data = $request->validated();
        $this->threadService->updateThread($thread->id, $data);
        return redirect()->route('threads.show', $thread->id)
            ->with('success', 'Le thread a été mis à jour avec succès!');
    }

    public function destroy(Thread $thread)
    {
        if (Auth::id() != $thread->user_id) {
            return redirect()->route('threads.show', $thread->id)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer ce thread.');
        }
        $this->threadService->deleteThread($thread->id);
        return redirect()->route('threads.index')
            ->with('success', 'Le thread a été supprimé avec succès!');
    }
    
    public function byCommunity(Request $request, $communityId)
    {
        $community = $this->communityService->getCommunityById($communityId);
        $threads = $this->threadService->getThreadsByCommunity($communityId);
        return view('threads.by_community', compact('threads', 'community'));
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $threads = $this->threadService->searchThreads($keyword);
        return view('threads.search', compact('threads', 'keyword'));
    }
}
