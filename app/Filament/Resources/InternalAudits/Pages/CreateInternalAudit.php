<?php

namespace App\Filament\Resources\InternalAudits\Pages;

use App\Filament\Resources\InternalAudits\InternalAuditResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInternalAudit extends CreateRecord
{
    protected static string $resource = InternalAuditResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return InternalAuditResource::getUrl('index');
    }
}
