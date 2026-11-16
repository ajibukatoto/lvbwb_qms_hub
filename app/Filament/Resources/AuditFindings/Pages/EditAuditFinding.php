<?php

namespace App\Filament\Resources\AuditFindings\Pages;

use App\Filament\Resources\AuditFindings\AuditFindingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuditFinding extends EditRecord
{
    protected static string $resource = AuditFindingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn (): bool => \Illuminate\Support\Facades\Gate::allows('audit-findings.update')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return AuditFindingResource::getUrl('index');
    }
}
