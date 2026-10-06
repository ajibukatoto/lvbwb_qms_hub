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
        $data['prepared_by'] = Auth::id();

        return $data;
    }
}

