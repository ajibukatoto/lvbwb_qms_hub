<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagementReview extends Model
{
    protected $table = 'management_reviews';

    protected $fillable = [
        'review_reference',
        'title',
        'meeting_date',
        'start_time',
        'end_time',
        'venue',
        'chairperson',
        'attendees',
        'agenda',

        // Management Review Inputs
        'previous_actions_status',
        'changes_in_internal_external_issues',
        'customer_satisfaction',
        'quality_objectives_performance',
        'process_performance',
        'nonconformities_corrective_actions',
        'audit_results',
        'risks_opportunities',
        'resource_adequacy',
        'improvement_opportunities',

        // Management Review Outputs
        'decisions',
        'resource_requirements',
        'improvement_decisions',
        'qms_changes',
        'overall_conclusion',

        // Status and Approval
        'status',
        'prepared_by',
        'approved_by',
        'approval_date',
        'remarks',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'meeting_date' => 'date',
            'approval_date' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship: Management Review has many Action Items
    |--------------------------------------------------------------------------
    */

    public function actions(): HasMany
    {
        return $this->hasMany(
            ManagementReviewAction::class,
            'management_review_id',
            'id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship: Management Review belongs to User (Creator)
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'id'
        );
    }
}
