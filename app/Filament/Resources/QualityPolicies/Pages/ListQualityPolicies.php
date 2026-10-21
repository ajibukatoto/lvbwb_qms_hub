<?php

namespace App\Filament\Resources\QualityPolicies\Pages;

use App\Filament\Resources\QualityPolicies\QualityPolicyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQualityPolicies extends ListRecords
{
    protected static string $resource = QualityPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Create Quality Policy'),
        ];
    }
}
