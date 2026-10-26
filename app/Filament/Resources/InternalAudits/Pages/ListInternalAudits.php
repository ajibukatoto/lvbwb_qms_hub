<?php

namespace App\Filament\Resources\InternalAudits\Pages;

use App\Filament\Resources\InternalAudits\InternalAuditResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternalAudits extends ListRecords
{
    protected static string $resource = InternalAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Schedule Internal Audit'),
        ];
    }
}
