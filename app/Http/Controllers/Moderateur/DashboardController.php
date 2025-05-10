<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use App\Models\Community;
use App\Models\User;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $communities = Community::where('creator_id', $user->id)
            ->withCount(['followers', 'posts'])
            ->get();
        
        $recentReports = DB::table('reports')
            ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->whereNull('reports.handled_at')
            ->select('reports.*', 'report_types.name as report_type_name', 'users.nom', 'users.prenom')
            ->orderBy('reports.created_at', 'desc')
            ->limit(5)
            ->get();
        
        $totalMembers = 0;
        $totalPosts = 0;
        $totalCommunities = $communities->count();
        
        foreach ($communities as $community) {
            $totalMembers += $community->followers_count;
            $totalPosts += $community->posts_count;
        }
        
        $pendingReportsCount = DB::table('reports')
            ->whereNull('handled_at')
            ->count();
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
        
        $communities = Community::where('creator_id', $user->id)
            ->withCount(['followers', 'posts'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('moderateur.communities.index', compact('communities'));
    }

    public function communityMembers(Community $community)
    {
        $this->authorize('manageCommunity', $community);
        $members = $community->followers()
            ->withCount('posts')
            ->orderBy('prenom')
            ->paginate(20);
        return view('moderateur.communities.members', compact('community', 'members'));
    }

    public function communityStats(Community $community)
    {
        $this->authorize('manageCommunity', $community);
        
        $postsPerDay = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('community_id', $community->id)
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $membersPerDay = DB::table('user_community')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('community_id', $community->id)
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        $topMembers = $community->followers()
            ->withCount(['posts' => function($query) use ($community) {
                $query->where('community_id', $community->id);
            }])
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('moderateur.communities.stats', compact(
            'community',
            'postsPerDay',
            'membersPerDay',
            'topMembers'
        ));
    }

    public function banUser(Request $request, Community $community)
    {
        $this->authorize('manageCommunity', $community);
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:255',
        ]);
        
        $user = User::findOrFail($validatedData['user_id']);
        
        if (!$community->followers()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas membre de la communauté.');
        }
        
        $community->followers()->detach($user->id);
        
        DB::table('community_bans')->insert([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'moderator_id' => Auth::id(),
            'reason' => $validatedData['reason'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('moderator.community.members', $community)
            ->with('success', 'L\'utilisateur a été banni de la communauté.');
    }
}
