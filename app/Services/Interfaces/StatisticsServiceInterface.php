<?php

namespace App\Services\Interfaces;

interface StatisticsServiceInterface
{
    public function getGeneralStats();
    public function getWeekStats($entity);
}
