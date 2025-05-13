<?php

namespace App\Services;

use App\Models\BannedUser;
use App\Models\Comment;
use App\Models\Post;
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
        return Report::with(['user', 'reportType', 'admin'])
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
    
    public function getReportsByContent($type, $id = null, $perPage = 15)
    {
        $query = Report::with(['user', 'reportType']);
        
        if ($type) {
            $query->where('reportable_type', $type);
        }
        
        if ($id) {
            $query->where('reportable_id', $id);
        }
        
        return $query->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
    
    public function handleReport($reportId, $adminId, $action, $notes = null)
    {
        $report = Report::findOrFail($reportId);
        
        if (!$report->handled_at) {
            $reportable = $report->reportable;
            switch ($action) {
                case 'content_removed':
                    if ($reportable) {
                        $reportable->delete();
                    }
                    break;
                    
                case 'user_banned':
                    if ($reportable) {
                        $userId = null;
                        $communityId = null;
                        
                        if ($reportable instanceof Post) {
                            $userId = $reportable->auteur_id;
                            $communityId = $reportable->community_id;
                        } elseif ($reportable instanceof Comment) {
                            $userId = $reportable->user_id;
                            if ($reportable->post) {
                                $communityId = $reportable->post->community_id;
                            }
                        }
                        if ($userId && $communityId) {
                            $ban = new BannedUser([
                                'user_id' => $userId,
                                'community_id' => $communityId,
                                'banned_by' => $adminId,
                                'reason' => $notes ?? 'Banni suite à un signalement',
                                'banned_until' => now()->addMonths(1) 
                            ]);
                            $ban->save();
                        }
                    }
                    break;
                    
                case 'ignored':
                    break;
                    
                case 'other':
                    break;
            }
            $report->handled_at = now();
            $report->admin_id = $adminId;
            $report->action_taken = $action;
            $report->admin_notes = $notes;
            $report->save();
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
            'unhandled' => Report::whereNull('handled_at')->count(), // Ajout pour compatibilité avec la vue
            'by_type' => DB::table('reports')
                ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
                ->select('report_types.name', DB::raw('count(*) as total'))
                ->groupBy('report_types.name')
                ->get(),
            'recent_daily' => DB::table('reports')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
                ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get(),
        ];
        return $stats;
    }
    public function getRecentUnhandledReports($limit = 5)
    {
        return Report::with(['user', 'reportType'])
            ->whereNull('handled_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function countPendingReports()
    {
        return Report::whereNull('handled_at')->count();
    }
    
    public function countHandledReports()
    {
        return Report::whereNotNull('handled_at')->count();
    }

    public function countReportsByPeriod($days = 30, $communityId = null)
    {
        $query = Report::whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days]);
        
        if ($communityId) {
            $query->whereHasMorph('reportable', ['App\Models\Post', 'App\Models\Comment'], function ($q) use ($communityId) {
                $q->where('community_id', $communityId);
            });
        }
        
        return $query->count();
    }

    public function countHandledReportsByPeriod($days = 30, $communityId = null)
    {
        $query = Report::whereNotNull('handled_at')
            ->whereRaw('handled_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days]);
        
        if ($communityId) {
            $query->whereHasMorph('reportable', ['App\Models\Post', 'App\Models\Comment'], function ($q) use ($communityId) {
                $q->where('community_id', $communityId);
            });
        }
        
        return $query->count();
    }

    public function getReportCountByContentType($days = 30, $communityId = null)
    {
        $baseQuery = Report::whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days]);
        
        if ($communityId) {
            $baseQuery->whereHasMorph('reportable', ['App\Models\Post', 'App\Models\Comment'], function ($q) use ($communityId) {
                $q->where('community_id', $communityId);
            });
        }
        
        $results = $baseQuery->select('reportable_type', DB::raw('count(*) as count'))
            ->groupBy('reportable_type')
            ->pluck('count', 'reportable_type')
            ->toArray();
        
        $contentTypes = [];
        foreach ($results as $type => $count) {
            $shortType = strtolower(class_basename($type));
            $contentTypes[$shortType] = $count;
        }
        return $contentTypes;
    }

    public function getReportCountByResolution($days = 30, $communityId = null)
    {
        $baseQuery = Report::whereNotNull('handled_at')
            ->whereRaw('handled_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days]);
        if ($communityId) {
            $baseQuery->whereHasMorph('reportable', ['App\Models\Post', 'App\Models\Comment'], function ($q) use ($communityId) {
                $q->where('community_id', $communityId);
            });
        }
        $results = $baseQuery->select('action_taken', DB::raw('count(*) as count'))
            ->groupBy('action_taken')
            ->pluck('count', 'action_taken')
            ->toArray();
        $possibleActions = ['ignored', 'content_removed', 'user_banned', 'other'];
        $countByResolution = [];
        foreach ($possibleActions as $action) {
            $countByResolution[$action] = $results[$action] ?? 0;
        }
        
        return $countByResolution;
    }

    public function getRecentHandledReports($days = 30, $communityId = null, $limit = 10)
    {
        $query = DB::table('reports')
            ->join('users', 'reports.user_id', '=', 'users.id')
            ->join('users as handlers', 'reports.admin_id', '=', 'handlers.id')
            ->join('report_types', 'reports.type_report_id', '=', 'report_types.id')
            ->select(
                'reports.*',
                'users.prenom',
                'users.nom',
                'handlers.prenom as handler_prenom',
                'handlers.nom as handler_nom',
                'report_types.name as report_type_name',
                DB::raw('LEFT(reports.raison, 100) as content_excerpt')
            )
            ->whereNotNull('reports.handled_at')
            ->whereRaw('reports.handled_at >= DATE_SUB(NOW(), INTERVAL ? DAY)', [$days])
            ->orderBy('reports.handled_at', 'desc');
        
        if ($communityId) {
            $query->join('posts', function ($join) use ($communityId) {
                $join->on('reports.reportable_id', '=', 'posts.id')
                    ->where('reports.reportable_type', '=', 'App\\Models\\Post')
                    ->where('posts.community_id', '=', $communityId);
            }, null, null, 'left outer')
            ->join('comments', function ($join) use ($communityId) {
                $join->on('reports.reportable_id', '=', 'comments.id')
                    ->where('reports.reportable_type', '=', 'App\\Models\\Comment')
                    ->where('comments.community_id', '=', $communityId);
            }, null, null, 'left outer')
            ->whereRaw('(posts.id IS NOT NULL OR comments.id IS NOT NULL)');
        }
        return $query->limit($limit)->get();
    }
}
