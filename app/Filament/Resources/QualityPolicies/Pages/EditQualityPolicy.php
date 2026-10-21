<?php

namespace App\Filament\Resources\QualityPolicies\Pages;

use App\Filament\Resources\QualityPolicies\QualityPolicyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQualityPolicy extends EditRecord
{
    protected static string $resource = QualityPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
