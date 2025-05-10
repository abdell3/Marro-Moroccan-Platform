<?php

namespace App\Services\Interfaces;

interface ReportTypeServiceInterface
{
    public function getAllReportTypes();
    
    public function getReportTypeById($id);
    
    public function createReportType(array $data);
    
    public function updateReportType($id, array $data);
    
    public function deleteReportType($id);
    
    public function getTypesWithReportsCount();
}