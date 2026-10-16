<?php

namespace App\Filament\Resources\InterestedParties\Pages;

use App\Filament\Resources\InterestedParties\InterestedPartyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInterestedParty extends CreateRecord
{
    protected static string $resource = InterestedPartyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return InterestedPartyResource::getUrl('index');
    }
}

