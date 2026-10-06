<?php

namespace App\Filament\Resources\QmsScopes\Pages;

use App\Filament\Resources\QmsScopes\QmsScopeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQmsScopes extends ListRecords
{
    protected static string $resource = QmsScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
