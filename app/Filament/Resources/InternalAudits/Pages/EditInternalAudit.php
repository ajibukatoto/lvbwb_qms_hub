<?php

namespace App\Filament\Resources\InternalAudits\Pages;

use App\Filament\Resources\InternalAudits\InternalAuditResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternalAudit extends EditRecord
{
    protected static string $resource = InternalAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return InternalAuditResource::getUrl('index');
    }
}
