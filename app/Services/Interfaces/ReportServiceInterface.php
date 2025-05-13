<?php

namespace App\Services\Interfaces;

interface ReportServiceInterface
{
    public function getAllReports($perPage = 15);
    public function getReportById($id);
    public function createReport(array $data);
    public function getUnhandledReports($perPage = 15);
    public function getHandledReports($perPage = 15);
    public function getReportsByType($typeId, $perPage = 15);
    public function getReportsByContent($type, $id, $perPage = 15);
    public function handleReport($reportId, $adminId, $action, $notes = null);
    public function getReportStatistics();
    public function getRecentUnhandledReports($limit = 5);
    public function countPendingReports();
    public function countHandledReports();
    public function countReportsByPeriod($days = 30, $communityId = null);
    public function countHandledReportsByPeriod($days = 30, $communityId = null);
    public function getReportCountByContentType($days = 30, $communityId = null);
    public function getReportCountByResolution($days = 30, $communityId = null);
    public function getRecentHandledReports($days = 30, $communityId = null, $limit = 10);
}