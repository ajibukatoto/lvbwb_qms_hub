<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterestedParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'party_type',
        'needs_and_expectations',
        'qms_relevance',
        'monitoring_method',
        'responsible_person',
        'review_date',
        'is_active',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'review_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
