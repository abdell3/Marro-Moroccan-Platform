<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ReportType;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'reportable_id',
        'reportable_type',
        'user_id',
        'date',
        'raison',
        'type_report_id',
        'handled_at',
        'admin_id',
        'action_taken',
        'admin_notes',
    ];

    protected $casts = [
        'date' => 'datetime',
        'handled_at' => 'datetime',
    ];


    public function reportable()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function reportType()
    {
        return $this->belongsTo(ReportType::class, 'type_report_id');
    }


    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'reportable_id')
                    ->where('reportable_type', Post::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class, 'reportable_id')
                    ->where('reportable_type', Community::class);
    }
   
    public function scopeForPosts($query)
    {
        return $query->where('reportable_type', Post::class);
    }
    
    public function scopeForCommunities($query)
    {
        return $query->where('reportable_type', Community::class);
    }

    public function scopeHandled($query)
    {
        return $query->whereNotNull('handled_at');
    }

    public function scopeUnhandled($query)
    {
        return $query->whereNull('handled_at');
    }
}
