<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\Tag;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\TagServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $postService;
    protected $communityService;
    protected $tagService;

    public function __construct(
        PostServiceInterface $postService,
        CommunityServiceInterface $communityService,
        TagServiceInterface $tagService
    ) {
        $this->postService = $postService;
        $this->communityService = $communityService;
        $this->tagService = $tagService;
    }

    public function index()
    {
        $recentPosts = $this->postService->getDerniersPosts(10);
        $popularCommunities = $this->communityService->getCommunitiesPopulaires(7);
        $popularTags = $this->tagService->getTagsPopulaires(10);
        return view('welcome', compact('recentPosts', 'popularCommunities', 'popularTags'));
    }
}