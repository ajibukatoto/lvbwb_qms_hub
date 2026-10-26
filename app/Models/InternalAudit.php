<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternalAudit extends Model
{
    protected $fillable = [
        'audit_reference',
        'title',
        'audit_type',
        'objective',
        'scope',
        'criteria',
        'department_or_process',
        'lead_auditor',
        'audit_team',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'status',
        'summary_of_results',
        'report_location',
        'report_date',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'planned_start_date' => 'date',
            'planned_end_date' => 'date',
            'actual_start_date' => 'date',
            'actual_end_date' => 'date',
            'report_date' => 'date',
        ];
    }
}
