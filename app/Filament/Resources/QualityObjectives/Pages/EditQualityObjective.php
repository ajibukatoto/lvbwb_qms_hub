<?php

namespace App\Filament\Resources\QualityObjectives\Pages;

use App\Filament\Resources\QualityObjectives\QualityObjectiveResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQualityObjective extends EditRecord
{
    protected static string $resource = QualityObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return QualityObjectiveResource::getUrl('index');
    }
}
