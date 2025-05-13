<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Community;
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
    }

    public function createForPost(Post $post)
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('reports.create', [
            'reportable' => $post,
            'reportableType' => 'post',
            'reportTypes' => $reportTypes
        ]);
    }

    public function createForComment(Comment $comment)
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('reports.create', [
            'reportable' => $comment,
            'reportableType' => 'comment',
            'reportTypes' => $reportTypes
        ]);
    }

    public function createForCommunity(Community $community)
    {
        $reportTypes = $this->reportTypeService->getAllReportTypes();
        return view('reports.create', [
            'reportable' => $community,
            'reportableType' => 'community',
            'reportTypes' => $reportTypes
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reportable_type' => 'required|string|in:App\\Models\\Post,App\\Models\\Comment,App\\Models\\Community',
            'reportable_id' => 'required|integer',
            'type_report_id' => 'required|exists:report_types,id',
            'raison' => 'required|string|max:1000',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['date'] = now();

        $report = $this->reportService->createReport($validatedData);

        return redirect()->back()->with('success', 'Votre signalement a été enregistré. Merci pour votre contribution à la communauté.');
    }

    public function ajaxReport(Request $request)
    {
        $validatedData = $request->validate([
            'reportable_type' => 'required|string|in:App\\Models\\Post,App\\Models\\Comment,App\\Models\\Community',
            'reportable_id' => 'required|integer',
            'type_report_id' => 'required|exists:report_types,id',
            'raison' => 'required|string|max:1000',
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['date'] = now();

        $report = $this->reportService->createReport($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Votre signalement a été enregistré.'
        ]);
    }
}
