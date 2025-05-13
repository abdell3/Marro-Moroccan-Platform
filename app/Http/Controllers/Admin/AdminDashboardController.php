<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use App\Services\Interfaces\StatisticsServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    protected $communityService;
    protected $postService;
    protected $reportService;
    protected $roleService;
    protected $userService;
    protected $statisticsService;

    public function __construct(
        CommunityServiceInterface $communityService,
        PostServiceInterface $postService,
        ReportServiceInterface $reportService,
        RoleServiceInterface $roleService,
        UserServiceInterface $userService,
        StatisticsServiceInterface $statisticsService
    ) {
        $this->communityService = $communityService;
        $this->postService = $postService;
        $this->reportService = $reportService;
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->statisticsService = $statisticsService;
        $this->middleware('check.role:Admin');
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = $this->statisticsService->getGeneralStats();
        // = [
        //     'users' => User::count(),
        //     'communities' => Community::count(),
        //     'posts' => Post::count(),
        //     'comments' => Comment::count(),
        //     'reports' => Report::count(),
        //     'pending_reports' => Report::whereNull('handled_at')->count()
        // ];

        $weekStats = [
            'users' => $this->statisticsService->getWeekStats('users'),
            'communities' => $this->statisticsService->getWeekStats('communities'),
            'posts' => $this->statisticsService->getWeekStats('posts'),
            'comments' => $this->statisticsService->getWeekStats('comments')
        ];

        $pendingReports = $this->reportService->getRecentUnhandledReports(5);
        $newUsers = User::orderBy('created_at', 'desc')->limit(10)->get();
        $activeCommunities = Community::withCount(['posts', 'members'])
            ->orderBy('posts_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'weekStats', 
            'pendingReports', 
            'newUsers', 
            'activeCommunities'
        ));
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $usersQuery = User::with('role');
        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
                $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($role) {
            $usersQuery->whereHas('role', function ($query) use ($role) {
                $query->where('id', $role);
            });
        }
        $users = $usersQuery->orderBy($sortField, $sortDirection)->paginate(15);
        $roles = $this->roleService->getAllRolesAlpha();
        return view('admin.users.index', compact('users', 'roles', 'search', 'role', 'sortField', 'sortDirection'));
    }

    public function showUser($id)
    {
        $user = User::with(['role', 'communities', 'posts', 'comments', 'badges'])->findOrFail($id);
        $stats = [
            'posts_count' => $user->posts->count(),
            'comments_count' => $user->comments->count(),
            'communities_count' => $user->communities->count(),
            'reports_submitted' => Report::where('user_id', $user->id)->count(),
            'reports_received' => $this->getReportsAgainstUser($user->id),
            'banned_count' => DB::table('banned_users')->where('user_id', $user->id)->count()
        ];
        return view('admin.users.show', compact('user', 'stats'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = $this->roleService->getAllRolesAlpha();
        $badges = Badge::all();
        return view('admin.users.edit', compact('user', 'roles', 'badges'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'badge_ids' => 'nullable|array',
            'badge_ids.*' => 'exists:badges,id'
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'role_id' => $request->role_id
        ]);
        if ($request->has('badge_ids')) {
            $user->badges()->sync($request->badge_ids);
        } else {
            $user->badges()->detach();
        }
        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function communities(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $communitiesQuery = Community::withCount(['posts', 'members']);
        if ($search) {
            $communitiesQuery->where('theme_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }
        $communities = $communitiesQuery->orderBy($sortField, $sortDirection)->paginate(15);
        return view('admin.communities.index', compact('communities', 'search', 'sortField', 'sortDirection'));
    }

    public function showCommunity($id)
    {
        $community = Community::with(['moderators'])->withCount(['posts', 'members'])->findOrFail($id);
        $stats = [
            'posts_today' => Post::where('community_id', $id)
                ->whereDate('created_at', today())->count(),
            'posts_week' => Post::where('community_id', $id)
                ->whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
            'posts_month' => Post::where('community_id', $id)
                ->whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
            'reports_count' => Report::whereHasMorph('reportable', [Post::class], function($query) use ($id) {
                $query->where('community_id', $id);
            })->count()
        ];
        $recentMembers = $community->members()->orderBy('user_community.created_at', 'desc')->limit(10)->get();
        $recentPosts = Post::where('community_id', $id)->orderBy('created_at', 'desc')->limit(10)->get();
        return view('admin.communities.show', compact('community', 'stats', 'recentMembers', 'recentPosts'));
    }

    public function editCommunity($id)
    {
        $community = Community::findOrFail($id);
        $moderators = User::whereHas('role', function($query) {
            $query->where('role_name', 'Moderateur');
        })->get();
        return view('admin.communities.edit', compact('community', 'moderators'));
    }

    public function updateCommunity(Request $request, $id)
    {
        $request->validate([
            'theme_name' => 'required|string|max:255',
            'description' => 'required|string',
            'moderator_ids' => 'nullable|array',
            'moderator_ids.*' => 'exists:users,id'
        ]);

        $community = Community::findOrFail($id);
        $community->update([
            'theme_name' => $request->theme_name,
            'description' => $request->description
        ]);

        if ($request->has('moderator_ids')) {
            $community->moderators()->sync($request->moderator_ids);
        }
        return redirect()->route('admin.communities.show', $community->id)
            ->with('success', 'Communauté mise à jour avec succès');
    }

    public function badges()
    {
        $badges = Badge::withCount('users')->get();
        return view('admin.badges.index', compact('badges'));
    }

    public function createBadge()
    {
        return view('admin.badges.create');
    }

    public function storeBadge(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'critere' => 'required|string',
            'logo' => 'nullable|string'
        ]);

        Badge::create([
            'name' => $request->nom,
            'description' => $request->description ?? $request->nom,
            'criteria' => $request->critere,
            'icon' => $request->logo ?? 'default-badge.svg'
        ]);
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge créé avec succès');
    }

    public function editBadge($id)
    {
        $badge = Badge::findOrFail($id);
        return view('admin.badges.edit', compact('badge'));
    }

    public function updateBadge(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'critere' => 'required|string',
            'logo' => 'nullable|string'
        ]);

        $badge = Badge::findOrFail($id);
        $badge->update([
            'name' => $request->nom,
            'description' => $request->description ?? $request->nom,
            'criteria' => $request->critere,
            'icon' => $request->logo ?? $badge->icon
        ]);
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge mis à jour avec succès');
    }

    public function deleteBadge($id)
    {
        $badge = Badge::findOrFail($id);
        $badge->users()->detach();
        $badge->delete();
        return redirect()->route('admin.badges.index')
            ->with('success', 'Badge supprimé avec succès');
    }

    public function statistics()
    {
        $totalStats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'communities' => Community::count(),
            'comments' => Comment::count()
        ];
        $newStats = [
            'daily' => [
                'users' => User::whereDate('created_at', today())->count(),
                'posts' => Post::whereDate('created_at', today())->count(),
                'communities' => Community::whereDate('created_at', today())->count(),
                'comments' => Comment::whereDate('created_at', today())->count()
            ],
            'weekly' => [
                'users' => User::whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
                'posts' => Post::whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
                'communities' => Community::whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
                'comments' => Comment::whereBetween('created_at', [now()->startOfWeek(), now()])->count()
            ],
            'monthly' => [
                'users' => User::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'posts' => Post::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'communities' => Community::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
                'comments' => Comment::whereBetween('created_at', [now()->startOfMonth(), now()])->count()
            ]
        ];

        $moderationStats = [
            'total_reports' => Report::count(),
            'pending_reports' => Report::whereNull('handled_at')->count(),
            'handled_reports' => Report::whereNotNull('handled_at')->count(),
            'by_type' => Report::select('reportable_type', DB::raw('count(*) as count'))
                ->groupBy('reportable_type')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [class_basename($item->reportable_type) => $item->count];
                })
        ];

        $communityActivity = Community::withCount(['posts', 'members'])
            ->orderBy('posts_count', 'desc')
            ->limit(10)
            ->get();

        $activeUsers = User::withCount(['posts', 'comments'])
            ->orderByRaw('posts_count + comments_count DESC')
            ->limit(10)
            ->get();

        return view('admin.statistics', compact(
            'totalStats', 
            'newStats', 
            'moderationStats', 
            'communityActivity', 
            'activeUsers'
        ));
    }

    private function getWeekNewStats($table)
    {
        $currentWeek = 0;
        $lastWeek = 0;
        switch ($table) {
            case 'users':
                $currentWeek = User::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = User::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'communities':
                $currentWeek = Community::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Community::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'posts':
                $currentWeek = Post::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Post::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'comments':
                $currentWeek = Comment::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Comment::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
        }
        $difference = $currentWeek - $lastWeek;
        $percentage = $lastWeek > 0 ? ($difference / $lastWeek) * 100 : ($currentWeek > 0 ? 100 : 0);
        return [
            'current' => $currentWeek,
            'previous' => $lastWeek,
            'difference' => $difference,
            'percentage' => round($percentage, 1)
        ];
    }

    private function getReportsAgainstUser($userId)
    {
        return Report::whereHasMorph(
            'reportable',
            [Post::class, Comment::class],
            function ($query) use ($userId) {
                $query->where('auteur_id', $userId)
                    ->orWhere('user_id', $userId);
            }
        )->count();
    }
    
    public function deleteUser($id)
    {
        try {
            $result = $this->userService->deleteUser($id);
            if ($result) {
                return redirect()->route('admin.users.index')
                    ->with('success', 'Utilisateur supprimé avec succès');
            } else {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Erreur lors de la suppression de l\'utilisateur');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
