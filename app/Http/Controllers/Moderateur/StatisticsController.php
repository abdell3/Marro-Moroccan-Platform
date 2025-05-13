<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use App\Services\Interfaces\CommunityServiceInterface;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
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

    public function index(Request $request)
    {
        $user = Auth::user();
        $period = $request->input('period', 30);
        $communityId = $request->input('community_id');
        $communities = $this->communityService->getCommunitiesCreatedByUser($user->id);
        $newMembersCount = $this->communityService->countNewMembersByPeriod($user->id, $period, $communityId);
        $newPostsCount = $this->communityService->countNewPostsByPeriod($user->id, $period, $communityId);
        $reportsReceivedCount = $this->reportService->countReportsByPeriod($period, $communityId);
        $reportsHandledCount = $this->reportService->countHandledReportsByPeriod($period, $communityId);
        $communityStats = $this->communityService->getCommunityStatsByPeriod($user->id, $period, $communityId);
        $reportsByContentType = $this->reportService->getReportCountByContentType($period, $communityId);
        $totalReports = array_sum($reportsByContentType);
        
        $reportsByContentTypePercentage = [];
        if ($totalReports > 0) {
            foreach ($reportsByContentType as $type => $count) {
                $reportsByContentTypePercentage[$type] = round(($count / $totalReports) * 100, 1);
            }
        }
        
        $reportsByResolution = $this->reportService->getReportCountByResolution($period, $communityId);
        $totalResolvedReports = array_sum($reportsByResolution);
        $reportsByResolutionPercentage = [];
        if ($totalResolvedReports > 0) {
            foreach ($reportsByResolution as $resolution => $count) {
                $reportsByResolutionPercentage[$resolution] = round(($count / $totalResolvedReports) * 100, 1);
            }
        }
        $recentHandledReports = $this->reportService->getRecentHandledReports($period, $communityId, 10);
        return view('moderateur.statistics.index', compact(
            'communities',
            'period',
            'communityId',
            'newMembersCount',
            'newPostsCount',
            'reportsReceivedCount',
            'reportsHandledCount',
            'communityStats',
            'reportsByContentType',
            'reportsByContentTypePercentage',
            'reportsByResolution',
            'reportsByResolutionPercentage',
            'recentHandledReports'
        ));
    }
}
