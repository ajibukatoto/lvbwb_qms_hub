<?php

namespace App\Filament\Resources\CorrectiveActions;

use App\Filament\Resources\CorrectiveActions\Pages\CreateCorrectiveAction;
use App\Filament\Resources\CorrectiveActions\Pages\EditCorrectiveAction;
use App\Filament\Resources\CorrectiveActions\Pages\ListCorrectiveActions;
use App\Filament\Resources\CorrectiveActions\Schemas\CorrectiveActionForm;
use App\Filament\Resources\CorrectiveActions\Tables\CorrectiveActionsTable;
use App\Models\CorrectiveAction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CorrectiveActionResource extends Resource
{
    protected static ?string $model = CorrectiveAction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CorrectiveActionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CorrectiveActionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCorrectiveActions::route('/'),
            'create' => CreateCorrectiveAction::route('/create'),
            'edit' => EditCorrectiveAction::route('/{record}/edit'),
        ];
    }
}
