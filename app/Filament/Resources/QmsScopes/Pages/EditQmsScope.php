<?php

namespace App\Filament\Resources\QmsScopes\Pages;

use App\Filament\Resources\QmsScopes\QmsScopeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQmsScope extends EditRecord
{
    protected static string $resource = QmsScopeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
