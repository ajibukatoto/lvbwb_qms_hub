<?php

namespace App\Filament\Resources\Nonconformities\Pages;

use App\Filament\Resources\Nonconformities\NonconformityResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateNonconformity extends CreateRecord
{
    protected static string $resource = NonconformityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return NonconformityResource::getUrl('index');
    }
}
