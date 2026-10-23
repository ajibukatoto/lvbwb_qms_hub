<?php

namespace App\Filament\Resources\RiskOpportunities\Pages;

use App\Filament\Resources\RiskOpportunities\RiskOpportunityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRiskOpportunity extends EditRecord
{
    protected static string $resource = RiskOpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
