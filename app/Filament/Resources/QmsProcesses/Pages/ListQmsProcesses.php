<?php

namespace App\Filament\Resources\QmsProcesses\Pages;

use App\Filament\Resources\QmsProcesses\QmsProcessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQmsProcesses extends ListRecords
{
    protected static string $resource = QmsProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
