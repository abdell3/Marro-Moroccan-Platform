<?php

namespace App\Http\Controllers\Moderateur;

use App\Http\Controllers\Controller;
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

    /**
     * Affiche le tableau de bord du modérateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les communautés créées par le modérateur
        $communities = Community::where('owner_id', $user->id)
            ->withCount(['followers', 'posts'])
            ->get();
        
        // Récupérer les derniers signalements non traités
        $recentReports = DB::table('reports')
            ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->whereNull('reports.handled_at')
            ->select('reports.*', 'report_types.name as report_type_name', 'users.nom', 'users.prenom')
            ->orderBy('reports.created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Statistiques des communautés du modérateur
        $totalMembers = 0;
        $totalPosts = 0;
        $totalCommunities = $communities->count();
        
        foreach ($communities as $community) {
            $totalMembers += $community->followers_count;
            $totalPosts += $community->posts_count;
        }
        
        // Nombre de signalements en attente
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

    /**
     * Affiche les communautés du modérateur
     */
    public function communities()
    {
        $user = Auth::user();
        
        $communities = Community::where('owner_id', $user->id)
            ->withCount(['followers', 'posts'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('moderateur.communities.index', compact('communities'));
    }

    /**
     * Affiche les membres d'une communauté
     */
    public function communityMembers(Community $community)
    {
        // Vérifier que le modérateur est bien le propriétaire de la communauté
        $this->authorize('manageCommunity', $community);
        
        $members = $community->followers()
            ->withCount('posts')
            ->orderBy('prenom')
            ->paginate(20);
        
        return view('moderateur.communities.members', compact('community', 'members'));
    }

    /**
     * Affiche les statistiques de la communauté
     */
    public function communityStats(Community $community)
    {
        // Vérifier que le modérateur est bien le propriétaire de la communauté
        $this->authorize('manageCommunity', $community);
        
        // Statistiques nombre de posts par jour (30 derniers jours)
        $postsPerDay = DB::table('posts')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('community_id', $community->id)
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Statistiques nombre de nouveaux membres par jour (30 derniers jours)
        $membersPerDay = DB::table('user_community')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('community_id', $community->id)
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top 5 des membres les plus actifs
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

    /**
     * Bannir un utilisateur d'une communauté
     */
    public function banUser(Request $request, Community $community)
    {
        // Vérifier que le modérateur est bien le propriétaire de la communauté
        $this->authorize('manageCommunity', $community);
        
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason' => 'required|string|max:255',
        ]);
        
        $user = User::findOrFail($validatedData['user_id']);
        
        // Vérifier si l'utilisateur est bien membre de la communauté
        if (!$community->followers()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Cet utilisateur n\'est pas membre de la communauté.');
        }
        
        // Détacher l'utilisateur de la communauté
        $community->followers()->detach($user->id);
        
        // Enregistrer le bannissement dans une table de log (à créer si nécessaire)
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
