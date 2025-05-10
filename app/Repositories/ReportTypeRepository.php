<?php

namespace App\Repositories;

use App\Models\ReportType;
use App\Repositories\Interfaces\ReportTypeRepositoryInterface;

class ReportTypeRepository extends BaseRepository implements ReportTypeRepositoryInterface
{
    public function __construct(ReportType $model)
    {
        parent::__construct($model);
    }
    
    public function getAllTypes()
    {
        return $this->model->orderBy('name')->get();
    }
    
    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
    
    public function getTypesWithReportsCount()
    {
        return $this->model->withCount('reports')->orderBy('name')->get();
    }
}