<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use App\Models\Community;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    protected $communityService;
    protected $reportService;

    public function __construct(
        CommunityServiceInterface $communityService,
        ReportServiceInterface $reportService
    ) {
        $this->communityService = $communityService;
        $this->reportService = $reportService;
        $this->middleware('auth');
        $this->middleware('role:Moderateur');
    }

    public function index()
    {
        $user = Auth::user();
        $communities = $this->communityService->getCommunitiesCreatedByUserWithCounts($user->id);
        $recentReports = $this->reportService->getRecentUnhandledReports(5);
        
        $totalMembers = 0;
        $totalPosts = 0;
        $totalCommunities = $communities->count();
        foreach ($communities as $community) {
            $totalMembers += $community->followers_count;
            $totalPosts += $community->posts_count;
        }
        $pendingReportsCount = $this->reportService->countPendingReports();
        return view('moderateur.dashboard', compact(
            'communities',
            'recentReports',
            'totalMembers',
            'totalPosts',
            'totalCommunities',
            'pendingReportsCount'
        ));
    }

    public function communities()
    {
        $user = Auth::user();
        $communities = $this->communityService->getCommunitiesCreatedByUserWithCounts($user->id);
        $communities = new LengthAwarePaginator(
            $communities->slice(0, 10),
            $communities->count(),
            10
        );
        return view('moderateur.communities.index', compact('communities'));
    }

    public function communityMembers(Community $community)
    {
        if (!Gate::check('manageCommunity', $community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }
        $members = $this->communityService->getCommunityMembersWithPostsCount($community->id, 20);
        return view('moderateur.communities.members', compact('community', 'members'));
    }

    public function communityStats(Community $community)
    {
        if (!Gate::check('manageCommunity', $community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }
        
        $postsCount = $this->communityService->getPostsCount($community->id);
        $membersCount = $this->communityService->getMembersCount($community->id);
        $recentPostsCount = $this->communityService->getRecentPostsCount($community->id, 30);
        $newMembersCount = $this->communityService->getNewMembersCount($community->id, 30);
        $topMembers = $this->communityService->getTopMembersWithPostsCount($community->id, 5);
        return view('moderateur.communities.stats', compact(
            'community',
            'postsCount',
            'membersCount',
            'recentPostsCount',
            'newMembersCount',
            'topMembers'
        ));
    }

    public function banUser(Request $request, Community $community)
    {
        if (!Gate::check('manageCommunity', $community)) {
            abort(403, 'Vous n\'êtes pas autorisé à gérer cette communauté.');
        }
        
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:255',
        ]);
        $success = $this->communityService->banUserFromCommunity(
            $community->id,
            $validatedData['user_id'],
            Auth::id(),
            $validatedData['reason']
        );
        if (!$success) {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas membre de la communauté.');
        }
        return redirect()->back()
            ->with('success', 'L\'utilisateur a été banni de la communauté.');
    }
}
