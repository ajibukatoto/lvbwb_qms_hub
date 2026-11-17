<?php

namespace App\Filament\Resources\Nonconformities\Pages;

use App\Filament\Resources\Nonconformities\NonconformityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNonconformities extends ListRecords
{
    protected static string $resource = NonconformityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
