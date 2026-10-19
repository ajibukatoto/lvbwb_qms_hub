<?php

namespace App\Filament\Resources\QmsProcesses\Pages;

use App\Filament\Resources\QmsProcesses\QmsProcessResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQmsProcess extends EditRecord
{
    protected static string $resource = QmsProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
