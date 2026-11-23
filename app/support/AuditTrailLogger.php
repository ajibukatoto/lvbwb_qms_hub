<?php

namespace App\Support;

use App\Models\AuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditTrailLogger
{
    public static function record(Model $model, string $event): void
    {
        // Prevent audit logs from recording themselves.
        if ($model instanceof AuditTrail) {
            return;
        }

        // Only record supported events.
        if (!in_array($event, [
            'created',
            'updated',
            'deleted',
            'forceDeleted',
        ], true)) {
            return;
        }

        $excludedFields = [
            'password',
            'remember_token',
            'api_token',
            'access_token',
            'refresh_token',
            'secret',
        ];

        $oldValues = [];
        $newValues = [];

        if (in_array($event, ['deleted', 'forceDeleted'], true)) {
            $oldValues = $model->getOriginal();
        }

        if ($event === 'created') {
            $newValues = $model->getAttributes();
        }

        if ($event === 'updated') {
            $changes = $model->getChanges();

            foreach (array_keys($changes) as $field) {
                $oldValues[$field] = $model->getOriginal($field);

                $newValues[$field] = $model->getAttributes()[$field] ?? null;
            }
        }

        // Remove sensitive fields.
        foreach ($excludedFields as $field) {
            unset($oldValues[$field], $newValues[$field]);
        }

        // Do not create empty update logs.
        if (
            $event === 'updated'
            && empty($newValues)
        ) {
            return;
        }

        $label = $model->getAttribute('title')
            ?? $model->getAttribute('name')
            ?? $model->getAttribute('reference_number')
            ?? $model->getAttribute('document_number')
            ?? $model->getKey();

        $ipAddress = null;
        $userAgent = null;
        $url = null;

        if (!app()->runningInConsole()) {
            $ipAddress = request()->ip();
            $userAgent = request()->userAgent();
            $url = request()->fullUrl();
        }

        AuditTrail::create([
            'user_id' => Auth::id(),

            'event' => $event,

            'auditable_type' => get_class($model),

            'auditable_id' => $model->getKey(),

            'auditable_label' => (string) $label,

            'old_values' => $oldValues ?: null,

            'new_values' => $newValues ?: null,

            'ip_address' => $ipAddress,

            'user_agent' => $userAgent,

            'url' => $url,
        ]);
    }
}
