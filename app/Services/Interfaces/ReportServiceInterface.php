<?php

namespace App\Services\Interfaces;

interface ReportServiceInterface
{
    public function getAllReports($perPage = 15);
    
    public function getReportById($id);
    
    public function createReport(array $data);
    
    /**
     * Get all unhandled reports
     *
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUnhandledReports($perPage = 15);
    
    public function getHandledReports($perPage = 15);
    
    public function getReportsByType($typeId, $perPage = 15);
    
    public function getReportsByContent($type, $id, $perPage = 15);
    
    public function handleReport($reportId, $adminId, $action, $notes = null);
    
    public function getReportStatistics();
}