<?php

namespace App\Filament\Resources\Nonconformities\Pages;

use App\Filament\Resources\Nonconformities\NonconformityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNonconformity extends EditRecord
{
    protected static string $resource = NonconformityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return NonconformityResource::getUrl('index');
    }
}
