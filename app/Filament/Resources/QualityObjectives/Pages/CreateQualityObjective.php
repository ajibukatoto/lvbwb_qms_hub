<?php

namespace App\Filament\Resources\QualityObjectives\Pages;

use App\Filament\Resources\QualityObjectives\QualityObjectiveResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQualityObjective extends CreateRecord
{
    protected static string $resource = QualityObjectiveResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return QualityObjectiveResource::getUrl('index');
    }
}
