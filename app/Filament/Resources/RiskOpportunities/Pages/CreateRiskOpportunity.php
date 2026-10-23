<?php

namespace App\Filament\Resources\RiskOpportunities\Pages;

use App\Filament\Resources\RiskOpportunities\RiskOpportunityResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRiskOpportunity extends CreateRecord
{
    protected static string $resource = RiskOpportunityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return RiskOpportunityResource::getUrl('index');
    }
}
