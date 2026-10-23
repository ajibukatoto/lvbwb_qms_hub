<?php

namespace App\Filament\Resources\RiskOpportunities\Pages;

use App\Filament\Resources\RiskOpportunities\RiskOpportunityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRiskOpportunities extends ListRecords
{
    protected static string $resource = RiskOpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
