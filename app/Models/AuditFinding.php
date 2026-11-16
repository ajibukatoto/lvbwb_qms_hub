<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditFinding extends Model
{
    protected $fillable = [
        'finding_reference',
        'internal_audit_id',
        'finding_title',
        'finding_type',
        'iso_clause',
        'finding_description',
        'objective_evidence',
        'requirement',
        'corrective_action_required',
        'responsible_person',
        'target_closure_date',
        'status',
        'root_cause',
        'closure_evidence',
        'closed_at',
        'verified_by',
        'verification_notes',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'target_closure_date' => 'date',
            'closed_at' => 'date',
        ];
    }

    public function internalAudit(): BelongsTo
    {
        return $this->belongsTo(
            InternalAudit::class,
            'internal_audit_id'
        );
    }
    public function findings(): HasMany
{
    return $this->hasMany(AuditFinding::class);
}

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
