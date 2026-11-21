<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagementReviewAction extends Model
{
    protected $table = 'management_review_actions';

    protected $fillable = [
        'management_review_id',
        'action_reference',
        'action_title',
        'action_description',
        'responsible_person',
        'responsible_department',
        'due_date',
        'completion_date',
        'status',
        'evidence_of_completion',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    /**
     * Action item belongs to one Management Review.
     */
    public function managementReview(): BelongsTo
    {
        return $this->belongsTo(
            ManagementReview::class,
            'management_review_id',
            'id'
        );
    }
}
