<?php

namespace App\Filament\Resources\InterestedParties\Pages;

use App\Filament\Resources\InterestedParties\InterestedPartyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInterestedParty extends EditRecord
{
    protected static string $resource = InterestedPartyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
