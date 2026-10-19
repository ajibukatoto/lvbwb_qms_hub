<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QmsProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'process_code',
        'name',
        'process_type',
        'purpose',
        'inputs',
        'activities',
        'outputs',
        'resources',
        'kpis',
        'risks_and_opportunities',
        'interaction_with',
        'owner_name',
        'status',
        'created_by',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
