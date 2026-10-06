<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QmsScope extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'scope_statement',
        'organizational_units',
        'locations',
        'services',
        'exclusions',
        'status',
        'effective_date',
        'review_date',
        'prepared_by',
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
