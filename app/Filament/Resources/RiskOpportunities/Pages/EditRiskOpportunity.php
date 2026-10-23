<?php

namespace App\Filament\Resources\RiskOpportunities\Pages;

use App\Filament\Resources\RiskOpportunities\RiskOpportunityResource;
use Filament\Resources\Pages\EditRecord;

class EditRiskOpportunity extends EditRecord
{
    protected static string $resource = RiskOpportunityResource::class;

    protected function getRedirectUrl(): string
    {
        return RiskOpportunityResource::getUrl('index');
    }
}
