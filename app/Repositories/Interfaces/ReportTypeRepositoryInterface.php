<?php

namespace App\Repositories\Interfaces;

interface ReportTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllTypes();
  
    public function findByName($name);

    public function getTypesWithReportsCount();
}