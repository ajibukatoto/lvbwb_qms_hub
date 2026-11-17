<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuditFinding extends Model
{
    protected $fillable = [
        'internal_audit_id',
        'title',
        'description',
        'finding_type',
        'iso_clause',
        'objective_evidence',
        'recommendation',
        'responsible_person',
        'target_date',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'target_date' => 'date',
        ];
    }

    /**
     * Audit finding belongs to an internal audit.
     */
    public function internalAudit(): BelongsTo
    {
        return $this->belongsTo(
            InternalAudit::class,
            'internal_audit_id'
        );
    }

    /**
     * Audit finding may have many nonconformities.
     */
    public function nonconformities(): HasMany
    {
        return $this->hasMany(
            Nonconformity::class,
            'audit_finding_id'
        );
    }

    /**
     * User who created the audit finding.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
