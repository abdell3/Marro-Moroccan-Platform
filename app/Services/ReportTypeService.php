<?php

namespace App\Services;

use App\Repositories\Interfaces\ReportTypeRepositoryInterface;
use App\Services\Interfaces\ReportTypeServiceInterface;

class ReportTypeService implements ReportTypeServiceInterface
{
    protected $reportTypeRepository;
    
    public function __construct(ReportTypeRepositoryInterface $reportTypeRepository)
    {
        $this->reportTypeRepository = $reportTypeRepository;
    }
    
    public function getAllReportTypes()
    {
        return $this->reportTypeRepository->getAllTypes();
    }
    
    public function getReportTypeById($id)
    {
        return $this->reportTypeRepository->find($id);
    }
    
    public function createReportType(array $data)
    {
        return $this->reportTypeRepository->create($data);
    }
    
    public function updateReportType($id, array $data)
    {
        return $this->reportTypeRepository->update($id, $data);
    }
    
    public function deleteReportType($id)
    {
        $reportType = $this->reportTypeRepository->find($id);
        if ($reportType->reports()->count() > 0) {
            throw new \Exception('Ce type de rapport est utilisé par des rapports existants et ne peut pas être supprimé.');
        }
        return $this->reportTypeRepository->delete($id);
    }
    
    public function getTypesWithReportsCount()
    {
        return $this->reportTypeRepository->getTypesWithReportsCount();
    }
}
