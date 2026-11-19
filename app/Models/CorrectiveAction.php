<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorrectiveAction extends Model
{
    protected $fillable = [
        'capa_reference',
        'nonconformity_id',
        'title',
        'root_cause',
        'correction',
        'corrective_action',
        'preventive_action',
        'responsible_person',
        'planned_completion_date',
        'actual_completion_date',
        'status',
        'verification_method',
        'verification_results',
        'effectiveness',
        'verification_date',
        'verified_by',
        'remarks',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'planned_completion_date' => 'date',
            'actual_completion_date' => 'date',
            'verification_date' => 'date',
        ];
    }

    public function nonconformity(): BelongsTo
    {
        return $this->belongsTo(
            Nonconformity::class,
            'nonconformity_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
