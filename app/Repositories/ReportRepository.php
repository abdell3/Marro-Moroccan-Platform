<?php

namespace App\Repositories;

use App\Models\Report;
use App\Models\Community;
use App\Models\Post;
use App\Models\Comment;
use App\Repositories\Interfaces\ReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }
 
    public function getUnhandledReports($perPage = 15)
    {
        return $this->model->with(['user', 'reportType', 'reportable'])
            ->whereNull('handled_at')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
 
    public function getHandledReports($perPage = 15)
    {
        return $this->model->with(['user', 'reportType', 'reportable', 'admin'])
            ->whereNotNull('handled_at')
            ->orderBy('handled_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportsByType($typeId, $perPage = 15)
    {
        return $this->model->with(['user', 'reportType', 'reportable'])
            ->where('type_report_id', $typeId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportsByUser($userId, $perPage = 15)
    {
        return $this->model->with(['user', 'reportType', 'reportable'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function getReportsByReportable($type, $id, $perPage = 15)
    {
        $modelClass = null;
        switch ($type) {
            case 'post':
                $modelClass = Post::class;
                break;
            case 'comment':
                $modelClass = Comment::class;
                break;
            case 'community':
                $modelClass = Community::class;
                break;
            default:
                return collect();
        }
        return $this->model->with(['user', 'reportType'])
            ->where('reportable_type', $modelClass)
            ->where('reportable_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function markAsHandled($reportId, $adminId, $actionTaken, $notes = null)
    {
        $report = $this->find($reportId);
        $report->update([
            'handled_at' => now(),
            'admin_id' => $adminId,
            'action_taken' => $actionTaken,
            'admin_notes' => $notes,
        ]);
        return $report;
    }
}