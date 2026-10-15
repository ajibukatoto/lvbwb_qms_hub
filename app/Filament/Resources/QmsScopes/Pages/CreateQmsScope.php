<?php

namespace App\Filament\Resources\QmsScopes\Pages;

use App\Filament\Resources\QmsScopes\QmsScopeResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQmsScope extends CreateRecord
{
    protected static string $resource = QmsScopeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Automatically record the logged-in user's ID.
        $data['prepared_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        // Return to the QMS Scopes table after saving.
        return QmsScopeResource::getUrl('index');
    }
}
