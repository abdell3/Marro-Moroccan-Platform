<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\StatisticsServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\CommunityServiceInterface;
use Illuminate\Http\Request;

class AdminTempController extends Controller
{
    private $statisticsService;
    private $userService;
    private $reportService;
    private $communityService;

    public function __construct(
        StatisticsServiceInterface $statisticsService,
        UserServiceInterface $userService,
        ReportServiceInterface $reportService,
        CommunityServiceInterface $communityService
    ) {
        $this->middleware('check.role:Admin');
        $this->statisticsService = $statisticsService;
        $this->userService = $userService;
        $this->reportService = $reportService;
        $this->communityService = $communityService;
    }

    public function index()
    {
        $stats = $this->statisticsService->getGeneralStats();

        $weeklyGrowth = [
            'users' => $this->statisticsService->getWeekStats('users'),
            'communities' => $this->statisticsService->getWeekStats('communities'),
            'posts' => $this->statisticsService->getWeekStats('posts'),
            'comments' => $this->statisticsService->getWeekStats('comments')
        ];

        $pendingReports = $this->reportService->getRecentUnhandledReports(5);
        $newUsers = $this->userService->getRecentUsers(10);
        $activeCommunities = $this->communityService->getActiveCommunities(5);
        return view('admin.dashboard', compact(
            'stats', 
            'weeklyGrowth', 
            'pendingReports', 
            'newUsers', 
            'activeCommunities'
        ));
    }


}