<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportType;
use App\Services\Interfaces\ReportTypeServiceInterface;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    protected $reportTypeService;

    public function __construct(ReportTypeServiceInterface $reportTypeService)
    {
        $this->reportTypeService = $reportTypeService;
        $this->middleware('auth');
        $this->middleware('role:Admin');
    }

    /**
     * Display a listing of the report types.
     */
    public function index()
    {
        $reportTypes = $this->reportTypeService->getTypesWithReportsCount();
        
        return view('admin.report-types.index', compact('reportTypes'));
    }

    /**
     * Show the form for creating a new report type.
     */
    public function create()
    {
        return view('admin.report-types.create');
    }

    /**
     * Store a newly created report type in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:report_types',
            'description' => 'nullable|string',
        ]);

        $reportType = $this->reportTypeService->createReportType($validatedData);

        return redirect()->route('admin.report-types.index')
            ->with('success', 'Type de rapport créé avec succès.');
    }

    /**
     * Display the specified report type.
     */
    public function show(ReportType $reportType)
    {
        return view('admin.report-types.show', compact('reportType'));
    }

    /**
     * Show the form for editing the specified report type.
     */
    public function edit(ReportType $reportType)
    {
        return view('admin.report-types.edit', compact('reportType'));
    }

    /**
     * Update the specified report type in storage.
     */
    public function update(Request $request, ReportType $reportType)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:report_types,name,' . $reportType->id,
            'description' => 'nullable|string',
        ]);

        $this->reportTypeService->updateReportType($reportType->id, $validatedData);

        return redirect()->route('admin.report-types.index')
            ->with('success', 'Type de rapport mis à jour avec succès.');
    }

    /**
     * Remove the specified report type from storage.
     */
    public function destroy(ReportType $reportType)
    {
        try {
            $this->reportTypeService->deleteReportType($reportType->id);
            return redirect()->route('admin.report-types.index')
                ->with('success', 'Type de rapport supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.report-types.index')
                ->with('error', $e->getMessage());
        }
    }
}
