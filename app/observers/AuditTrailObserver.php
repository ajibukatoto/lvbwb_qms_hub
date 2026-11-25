<?php

namespace App\Observers;

use App\Models\AuditTrail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditTrailObserver
{
    protected array $oldValues = [];

    public function created(Model $model): void
    {
        $this->record($model, 'created', [], $this->clean($model->getAttributes()));
    }

    public function updating(Model $model): void
    {
        $key = spl_object_id($model);

        $this->oldValues[$key] = [];

        foreach ($model->getDirty() as $field => $value) {
            $this->oldValues[$key][$field] = $model->getOriginal($field);
        }
    }

    public function updated(Model $model): void
    {
        $key = spl_object_id($model);

        $old = $this->oldValues[$key] ?? [];
        $new = [];

        foreach ($model->getChanges() as $field => $value) {
            if (array_key_exists($field, $old)) {
                $new[$field] = $model->getAttribute($field);
            }
        }

        unset($this->oldValues[$key]);

        $this->record(
            $model,
            'updated',
            $this->clean($old),
            $this->clean($new)
        );
    }

    public function deleted(Model $model): void
    {
        $this->record(
            $model,
            'deleted',
            $this->clean($model->getOriginal()),
            []
        );
    }

    protected function record(
        Model $model,
        string $event,
        array $oldValues,
        array $newValues
    ): void {
        if ($model instanceof AuditTrail) {
            return;
        }

        $label = null;

        foreach ([
            'title',
            'name',
            'reference_number',
            'document_number',
            'code',
        ] as $field) {
            if (!empty($model->getAttribute($field))) {
                $label = $model->getAttribute($field);
                break;
            }
        }

        AuditTrail::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'auditable_label' => $label,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => app()->runningInConsole()
                ? null : Request::ip(),
            'user_agent' => app()->runningInConsole()
                ? null : Request::userAgent(),
            'url' => app()->runningInConsole()
                ? null : Request::fullUrl(),
        ]);
    }

    protected function clean(array $values): array
    {
        $excluded = [
            'password',
            'remember_token',
            'api_token',
            'access_token',
            'refresh_token',
            'secret',
        ];

        foreach ($excluded as $field) {
            unset($values[$field]);
        }

        return $values;
    }
}