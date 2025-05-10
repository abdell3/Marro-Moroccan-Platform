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
        // Utilisons la pagination pour les posts récents
        $recentPosts = $this->postService->getDerniersPostsPagines(10); 
        $popularCommunities = $this->communityService->getCommunitiesPopulaires(7);
        $popularTags = $this->tagService->getTagsPopulaires(10);
        $isAuthenticated = auth()->check();
        $user = auth()->user();
        
        // Debug: Ajoutons des informations pour vérifier la pagination
        if ($recentPosts instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            \Illuminate\Support\Facades\Log::info('Home - Pagination trouvée: ' . $recentPosts->total() . ' éléments, ' . $recentPosts->perPage() . ' par page');
        } else {
            \Illuminate\Support\Facades\Log::warning('Home - Pas de pagination!');  
        }
        
        return view('welcome', compact('recentPosts', 'popularCommunities', 'popularTags', 'isAuthenticated', 'user'));
    }
}