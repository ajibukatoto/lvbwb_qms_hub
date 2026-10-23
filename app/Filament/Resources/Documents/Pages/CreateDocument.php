<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['prepared_by'] = Auth::id();

        // Approval is not granted during document creation.
        $data['reviewed_by'] = null;
        $data['approved_by'] = null;
        $data['approved_at'] = null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return DocumentResource::getUrl('index');
    }
}
