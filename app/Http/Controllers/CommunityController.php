<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Http\Requests\StoreCommunityRequest;
use App\Http\Requests\UpdateCommunityRequest;
use App\Services\Interfaces\CommunityServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    protected $communityService;
    
    public function __construct(CommunityServiceInterface $communityService)
    {
        $this->communityService = $communityService;
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index()
    {
        $communities = $this->communityService->getAllCommunitiesAlpha();
        $populaires = $this->communityService->getCommunitiesPopulaires(5);
        return view('communities.index', compact('communities', 'populaires'));
    }

    public function create()
    {
        if (request()->is('moderator/*')) {
            return view('communities.create', ['isModeratorContext' => true]);
        }
        return view('communities.create');
    }

    public function store(StoreCommunityRequest $request)
    {
        $data = $request->validated();
        $community = $this->communityService->createCommunity($data);
        $this->communityService->followCommunity(Auth::id(), $community->id);
        if (request()->is('moderator/*')) {
            return redirect()
                ->route('moderator.communities.show', $community->id)
                ->with('success', 'La communauté a été créée avec succès!');
        }
        
        return redirect()
            ->route('communities.show', $community->id)
            ->with('success', 'La communauté a été créée avec succès!');
    }
    
    public function show(Community $community)
    {
        if (request()->is('moderator/communities/*') && !request()->routeIs('moderator.community.*')) {
            return view('moderateur.communities.show', compact('community'));
        }

        $posts = $this->communityService->getPosts($community->id, 10);
        $threads = $this->communityService->getThreads($community->id, 10);
        $isFollowing = Auth::check() ? $this->communityService->userFollowsCommunity(Auth::id(), $community->id) : false;
        $membersCount = $this->communityService->countMembers($community->id);
        return view('communities.show', compact('community', 'posts', 'threads', 'isFollowing', 'membersCount'));
    }

    public function edit(Community $community)
    {
        if (request()->is('moderator/*')) {
            return view('communities.edit', compact('community'));
        }
        
        if (Auth::id() != $community->creator_id) {
            return redirect()->route('communities.show', $community->id)
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette communauté.');
        }
        return view('communities.edit', compact('community'));
    }

    public function update(UpdateCommunityRequest $request, Community $community)
    {
        $data = $request->validated();
        $this->communityService->updateCommunity($community->id, $data);
        if (request()->is('moderator/*')) {
            return redirect()->route('moderator.communities.show', $community->id)
                ->with('success', 'La communauté a été mise à jour avec succès!');
        }
        return redirect()->route('communities.show', $community->id)
            ->with('success', 'La communauté a été mise à jour avec succès!');
    }

    public function destroy(Community $community)
    {
        if (Auth::id() != $community->creator_id) {
            return redirect()->route('communities.show', $community->id)
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette communauté.');
        }
        $this->communityService->deleteCommunity($community->id);
        return redirect()
            ->route('communities.index')
            ->with('success', 'La communauté a été supprimée avec succès!');
    }
    
    public function follow(Community $community)
    {
        $this->communityService->followCommunity(Auth::id(), $community->id);
        return redirect()->back()->with('success', 'Vous suivez maintenant cette communauté.');
    }
    
    public function unfollow(Community $community)
    {
        $this->communityService->unfollowCommunity(Auth::id(), $community->id);
        return redirect()->back()->with('success', 'Vous ne suivez plus cette communauté.');
    }
    
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $communities = $this->communityService->searchCommunities($keyword);
        return view('communities.search', compact('communities', 'keyword'));
    }
}
