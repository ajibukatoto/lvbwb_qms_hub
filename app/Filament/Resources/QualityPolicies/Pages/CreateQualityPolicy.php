<?php

namespace App\Filament\Resources\QualityPolicies\Pages;

use App\Filament\Resources\QualityPolicies\QualityPolicyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateQualityPolicy extends CreateRecord
{
    protected static string $resource = QualityPolicyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['prepared_by'] = Auth::id();

        // Approval lazima ifanyike kupitia utaratibu ulioidhinishwa.
        $data['approved_by'] = null;
        $data['approved_at'] = null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return QualityPolicyResource::getUrl('index');
    }
}
