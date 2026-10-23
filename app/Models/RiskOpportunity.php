<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskOpportunity extends Model
{
    protected $fillable = [
        'reference_code',
        'title',
        'type',
        'category',
        'description',
        'potential_effect',
        'likelihood',
        'impact',
        'risk_score',
        'existing_controls',
        'planned_actions',
        'responsible_person',
        'target_date',
        'status',
        'review_notes',
        'last_reviewed_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'likelihood' => 'integer',
            'impact' => 'integer',
            'risk_score' => 'integer',
            'target_date' => 'date',
            'last_reviewed_at' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (RiskOpportunity $risk): void {
            $risk->risk_score =
                (int) $risk->likelihood * (int) $risk->impact;
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
