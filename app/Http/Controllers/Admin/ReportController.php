<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use App\Services\Interfaces\ReportServiceInterface;
use App\Services\Interfaces\ReportTypeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

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
        $this->middleware('role:Admin');
    }

    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $typeId = $request->query('type_id');
        if ($status === 'unhandled') {
            $reports = $this->reportService->getUnhandledReports();
        } elseif ($status === 'handled') {
            $reports = $this->reportService->getHandledReports();
        } elseif ($typeId) {
            $reports = $this->reportService->getReportsByType($typeId);
        } else {
            $reports = $this->reportService->getAllReports();
        }
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        $statistics = $this->reportService->getReportStatistics();
        return view('admin.reports.index', compact('reports', 'reportTypes', 'statistics', 'status', 'typeId'));
    }

    public function show(Report $report)
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('admin.reports.show', compact('report', 'reportTypes'));
    }

    public function handle(Request $request, Report $report)
    {
        $validatedData = $request->validated();
        $this->reportService->handleReport(
            $report->id,
            Auth::id(),
            $validatedData['action_taken'],
            $validatedData['admin_notes']
        );
        return redirect()->route('admin.reports.index')
            ->with('success', 'Rapport traité avec succès.');
    }

    public function statistics()
    {
        $statistics = $this->reportService->getReportStatistics();
        return view('admin.reports.statistics', compact('statistics'));
    }
}
