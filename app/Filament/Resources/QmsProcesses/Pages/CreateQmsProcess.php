<?php

namespace App\Filament\Resources\QmsProcesses\Pages;

use App\Filament\Resources\QmsProcesses\QmsProcessResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQmsProcess extends CreateRecord
{
    protected static string $resource = QmsProcessResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return QmsProcessResource::getUrl('index');
    }
}

