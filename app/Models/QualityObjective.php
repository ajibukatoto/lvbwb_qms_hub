<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityObjective extends Model
{
    protected $fillable = [
        'objective_code',
        'title',
        'description',
        'related_process',
        'kpi_name',
        'measurement_method',
        'unit_of_measure',
        'baseline_value',
        'target_value',
        'actual_value',
        'measurement_frequency',
        'responsible_person',
        'start_date',
        'due_date',
        'last_review_date',
        'progress_percentage',
        'status',
        'review_notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'baseline_value' => 'decimal:2',
            'target_value' => 'decimal:2',
            'actual_value' => 'decimal:2',
            'progress_percentage' => 'integer',
            'start_date' => 'date',
            'due_date' => 'date',
            'last_review_date' => 'date',
        ];
    }
}
