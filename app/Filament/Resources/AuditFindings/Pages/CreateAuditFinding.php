<?php

namespace App\Filament\Resources\AuditFindings\Pages;

use App\Filament\Resources\AuditFindings\AuditFindingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateAuditFinding extends CreateRecord
{
    protected static string $resource = AuditFindingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return AuditFindingResource::getUrl('index');
    }
}
