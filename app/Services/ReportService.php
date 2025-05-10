<?php

namespace App\Services;

use App\Models\Report;
use App\Services\Interfaces\ReportServiceInterface;
use Illuminate\Support\Facades\DB;

class ReportService implements ReportServiceInterface
{
    public function getAllReports($perPage = 15)
    {
        return Report::with(['user', 'reportType'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportById($id)
    {
        return Report::with(['user', 'reportType'])->findOrFail($id);
    }
    
    public function createReport(array $data)
    {
        return Report::create($data);
    }
    
    public function getUnhandledReports($perPage = 15)
    {
        return Report::with(['user', 'reportType'])
            ->whereNull('handled_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getHandledReports($perPage = 15)
    {
        return Report::with(['user', 'reportType', 'handler'])
            ->whereNotNull('handled_at')
            ->orderBy('handled_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportsByType($typeId, $perPage = 15)
    {
        return Report::with(['user', 'reportType'])
            ->where('type_report_id', $typeId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportsByContent($type, $id, $perPage = 15)
    {
        return Report::with(['user', 'reportType'])
            ->where('reportable_type', $type)
            ->where('reportable_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function handleReport($reportId, $adminId, $action, $notes = null)
    {
        $report = Report::findOrFail($reportId);
        
        if (!$report->handled_at) {
            $report->handled_at = now();
            $report->handler_id = $adminId;
            $report->action_taken = $action;
            $report->admin_notes = $notes;
            $report->save();
            
            // Vous pourriez ajouter ici une logique supplémentaire
            // comme le bannissement d'un utilisateur, la suppression de contenu, etc.
            
            return true;
        }
        
        return false;
    }
    
    public function getReportStatistics()
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::whereNull('handled_at')->count(),
            'handled' => Report::whereNotNull('handled_at')->count(),
            'by_type' => DB::table('reports')
                ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
                ->select('report_types.name', DB::raw('count(*) as total'))
                ->groupBy('report_types.name')
                ->get(),
            'recent_daily' => DB::table('reports')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
        
        return $stats;
    }
}