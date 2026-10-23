<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'document_code',
        'title',
        'category',
        'description',
        'file_path',
        'original_file_name',
        'mime_type',
        'file_size',
        'version',
        'status',
        'effective_date',
        'review_date',
        'prepared_by',
        'reviewed_by',
        'approved_by',
        'approved_at',
        'approval_comments',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'review_date' => 'date',
            'approved_at' => 'datetime',
            'file_size' => 'integer',
        ];
    }

    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
