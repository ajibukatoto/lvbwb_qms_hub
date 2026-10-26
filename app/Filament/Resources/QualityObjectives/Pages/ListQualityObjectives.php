<?php

namespace App\Filament\Resources\QualityObjectives\Pages;

use App\Filament\Resources\QualityObjectives\QualityObjectiveResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQualityObjectives extends ListRecords
{
    protected static string $resource = QualityObjectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Register Quality Objective'),
        ];
    }
}
