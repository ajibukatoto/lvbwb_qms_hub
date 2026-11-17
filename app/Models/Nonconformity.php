<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nonconformity extends Model
{
    protected $fillable = [
        'ncr_reference',
        'audit_finding_id',
        'title',
        'source',
        'department_or_process',
        'severity',
        'iso_clause',
        'identified_date',
        'nonconformity_description',
        'objective_evidence',
        'immediate_correction',
        'responsible_person',
        'target_resolution_date',
        'status',
        'review_notes',
        'closed_date',
        'verified_by',
        'closure_evidence',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'identified_date' => 'date',
            'target_resolution_date' => 'date',
            'closed_date' => 'date',
        ];
    }

    /**
     * A nonconformity may be linked to an audit finding.
     */
    public function auditFinding(): BelongsTo
    {
        return $this->belongsTo(
            AuditFinding::class,
            'audit_finding_id'
        );
    }

    /**
     * User who created the nonconformity.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
