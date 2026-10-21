<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityPolicy extends Model
{
    protected $fillable = [
        'policy_code',
        'title',
        'policy_statement',
        'version',
        'status',
        'effective_date',
        'review_date',
        'prepared_by',
        'approved_by',
        'approved_at',
        'approval_comments',
        'document_file',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'review_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
