<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Community;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceInterface
{
    protected $reportRepository;
    protected $reportTypeRepository;
    
    public function __construct(
        ReportRepositoryInterface $reportRepository,
        ReportTypeRepositoryInterface $reportTypeRepository
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportTypeRepository = $reportTypeRepository;
    }
    
    public function getAllReports($perPage = 15)
    {
        return $this->reportRepository->paginate($perPage);
    }
    
    public function getReportById($id)
    {
        return $this->reportRepository->find($id);
    }
    
    public function createReport(array $data)
    {
        if (!isset($data['date'])) {
            $data['date'] = now();
        }
        if (!isset($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }
        return $this->reportRepository->create($data);
    }
    
    public function getUnhandledReports($perPage = 15)
    {
        return $this->reportRepository->getUnhandledReports($perPage);
    }
    
    public function getHandledReports($perPage = 15)
    {
        return $this->reportRepository->getHandledReports($perPage);
    }
    
    public function getReportsByType($typeId, $perPage = 15)
    {
        return $this->reportRepository->getReportsByType($typeId, $perPage);
    }
    
    public function getReportsByContent($type, $id, $perPage = 15)
    {
        return $this->reportRepository->getReportsByReportable($type, $id, $perPage);
    }
    
    public function handleReport($reportId, $adminId, $action, $notes = null)
    {
        return $this->reportRepository->markAsHandled($reportId, $adminId, $action, $notes);
    }
    
    public function getReportStatistics()
    {
        $totalReports = $this->reportRepository->all()->count();
        $handledReports = $this->reportRepository->where(['handled_at' => null])->count();
        $unhandledReports = $totalReports - $handledReports;
        $reportsByType = DB::table('reports')
            ->select('report_types.name', DB::raw('count(*) as total'))
            ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
            ->groupBy('report_types.name')
            ->orderBy('total', 'desc')
            ->get();
        
        $reportsByContentType = DB::table('reports')
            ->select('reportable_type', DB::raw('count(*) as total'))
            ->groupBy('reportable_type')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                $parts = explode('\\', $item->reportable_type);
                $className = end($parts);
                return [
                    'type' => $className,
                    'total' => $item->total,
                ];
            });
        return [
            'total' => $totalReports,
            'handled' => $handledReports,
            'unhandled' => $unhandledReports,
            'by_type' => $reportsByType,
            'by_content_type' => $reportsByContentType,
        ];
    }
}