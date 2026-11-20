<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Training extends Model
{
    protected $fillable = [
        'training_reference',
        'title',
        'description',
        'training_type',
        'department',
        'trainer',
        'venue',
        'start_date',
        'end_date',
        'participants',
        'number_of_participants',
        'training_cost',
        'status',
        'training_outcomes',
        'evaluation_results',
        'competence_assessment',
        'remarks',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'training_cost' => 'decimal:2',
            'number_of_participants' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
}
