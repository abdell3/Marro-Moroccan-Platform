<?php

namespace App\Repositories\Interfaces;

interface ReportRepositoryInterface extends BaseRepositoryInterface
{
    public function getUnhandledReports($perPage = 15);
    
    public function getHandledReports($perPage = 15);

    public function getReportsByType($typeId, $perPage = 15);

    public function getReportsByUser($userId, $perPage = 15);

    public function getReportsByReportable($type, $id, $perPage = 15);

    public function markAsHandled($reportId, $adminId, $actionTaken, $notes = null);
}