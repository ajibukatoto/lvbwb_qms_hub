<?php

namespace App\Filament\Resources\ManagementReviews\Pages;

use App\Filament\Resources\ManagementReviews\ManagementReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditManagementReview extends EditRecord
{
    protected static string $resource = ManagementReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
