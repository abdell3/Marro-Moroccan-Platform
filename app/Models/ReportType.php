<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class ReportType extends Model
{
    /** @use HasFactory<\Database\Factories\ReportTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class, 'type_report_id');
    }
    
}
