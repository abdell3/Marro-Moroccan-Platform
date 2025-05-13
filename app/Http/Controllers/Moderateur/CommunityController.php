<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use App\Models\Community;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommunityController extends Controller
{
    protected $communityService;
    protected $postService;
    
    public function __construct(
        CommunityServiceInterface $communityService,
        PostServiceInterface $postService
    )
    {
        $this->communityService = $communityService;
        $this->postService = $postService;
        $this->middleware('auth');
        $this->middleware('role:Moderateur');
    }

    public function show(Community $community)
    {
        if (!Gate::check('manageCommunity', $community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }
        $posts = $this->postService->getPostsWithAuteur($community->id, 10);
        $membersCount = $this->communityService->getMembersCount($community->id);
        return view('moderateur.communities.show', compact('community', 'posts', 'membersCount'));
    }
}
