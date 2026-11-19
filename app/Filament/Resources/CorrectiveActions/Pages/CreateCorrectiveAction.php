<?php

namespace App\Filament\Resources\CorrectiveActions\Pages;

use App\Filament\Resources\CorrectiveActions\CorrectiveActionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCorrectiveAction extends CreateRecord
{
    protected static string $resource = CorrectiveActionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return CorrectiveActionResource::getUrl('index');
    }
}
