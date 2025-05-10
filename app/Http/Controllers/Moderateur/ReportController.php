<?php

namespace App\Http\Controllers\Moderateur;

use Illuminate\Routing\Controller;
use App\Models\Report;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\ReportTypeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $reportService;
    protected $reportTypeService;

    public function __construct(
        ReportServiceInterface $reportService,
        ReportTypeServiceInterface $reportTypeService
    ) {
        $this->reportService = $reportService;
        $this->reportTypeService = $reportTypeService;
        $this->middleware('auth');
        $this->middleware('role:Moderateur');
    }

    public function index()
    {
        $reports = $this->reportService->getUnhandledReports();
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('moderateur.reports.index', compact('reports', 'reportTypes'));
    }

    public function show(Report $report)
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('moderateur.reports.show', compact('report', 'reportTypes'));
    }

    public function handle(Request $request, Report $report)
    {
        $validatedData = $request->validate([
            'action_taken' => 'required|string|in:ignored,content_removed,user_banned,other',
            'admin_notes' => 'nullable|string',
        ]);
        $this->reportService->handleReport(
            $report->id,
            Auth::id(),
            $validatedData['action_taken'],
            $validatedData['admin_notes']
        );
        return redirect()->route('moderateur.reports.index')
            ->with('success', 'Rapport traité avec succès.');
    }

    public function posts()
    {
        $reports = $this->reportService->getReportsByContent('post', null, 15);
        return view('moderateur.reports.posts', compact('reports'));
    }

    public function communities()
    {
        $reports = $this->reportService->getReportsByContent('community', null, 15);
        return view('moderateur.reports.communities', compact('reports'));
    }

    public function comments()
    {
        $reports = $this->reportService->getReportsByContent('comment', null, 15);
        return view('moderateur.reports.comments', compact('reports'));
    }
}
