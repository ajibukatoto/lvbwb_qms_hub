<?php

namespace App\Filament\Resources\InterestedParties\Pages;

use App\Filament\Resources\InterestedParties\InterestedPartyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInterestedParties extends ListRecords
{
    protected static string $resource = InterestedPartyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
