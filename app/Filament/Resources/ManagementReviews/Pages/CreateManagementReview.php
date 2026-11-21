<?php

namespace App\Filament\Resources\ManagementReviews\Pages;

use App\Filament\Resources\ManagementReviews\ManagementReviewResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateManagementReview extends CreateRecord
{
    protected static string $resource = ManagementReviewResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return ManagementReviewResource::getUrl('index');
    }
}
