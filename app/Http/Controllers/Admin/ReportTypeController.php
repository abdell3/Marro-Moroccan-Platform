<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreReportTypeRequest;
use App\Http\Requests\UpdateReportTypeRequest;
use ILLuminate\Routing\Controller;
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

    public function index()
    {
        $reportTypes = $this->reportTypeService->getTypesWithReportsCount();
        return view('admin.report-types.index', compact('reportTypes'));
    }
    
    public function create()
    {
        return view('admin.report-types.create');
    }

    public function store(StoreReportTypeRequest $request)
    {
        $validatedData = $request->validated();

        $reportType = $this->reportTypeService->createReportType($validatedData);
        return redirect()->route('admin.report-types.index')
            ->with('success', 'Type de rapport créé avec succès.');
    }

    public function show(ReportType $reportType)
    {
        return view('admin.report-types.show', compact('reportType'));
    }

    public function edit(ReportType $reportType)
    {
        return view('admin.report-types.edit', compact('reportType'));
    }

    public function update(UpdateReportTypeRequest $request, ReportType $reportType)
    {
        $validatedData = $request->validated($reportType);

        $this->reportTypeService->updateReportType($reportType->id, $validatedData);
        return redirect()->route('admin.report-types.index')
            ->with('success', 'Type de rapport mis à jour avec succès.');
    }

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
