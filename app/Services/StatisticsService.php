<?php

namespace App\Services;

use App\Models\User;
use App\Models\Community;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Report;
use App\Services\Interfaces\StatisticsServiceInterface;

class StatisticsService implements StatisticsServiceInterface
{
    public function getGeneralStats()
    {
        return [
            'users' => User::count(),
            'communities' => Community::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
            'reports' => Report::count(),
            'pending_reports' => Report::whereNull('handled_at')->count()
        ];
    }

    public function getWeekStats($table)
    {
        $currentWeek = 0;
        $lastWeek = 0;
        
        switch ($table) {
            case 'users':
                $currentWeek = User::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = User::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'communities':
                $currentWeek = Community::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Community::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'posts':
                $currentWeek = Post::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Post::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
            case 'comments':
                $currentWeek = Comment::whereBetween('created_at', [now()->startOfWeek(), now()])->count();
                $lastWeek = Comment::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->count();
                break;
        }
            
        $difference = $currentWeek - $lastWeek;
        $percentage = $lastWeek > 0 ? ($difference / $lastWeek) * 100 : ($currentWeek > 0 ? 100 : 0);
        return [
            'current' => $currentWeek,
            'previous' => $lastWeek,
            'difference' => $difference,
            'percentage' => round($percentage, 1)
        ];
    }
}
