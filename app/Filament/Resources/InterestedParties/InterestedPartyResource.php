<?php

namespace App\Filament\Resources\InterestedParties;

use App\Filament\Resources\InterestedParties\Pages\CreateInterestedParty;
use App\Filament\Resources\InterestedParties\Pages\EditInterestedParty;
use App\Filament\Resources\InterestedParties\Pages\ListInterestedParties;
use App\Filament\Resources\InterestedParties\Schemas\InterestedPartyForm;
use App\Filament\Resources\InterestedParties\Tables\InterestedPartiesTable;
use App\Models\InterestedParty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InterestedPartyResource extends Resource
{
    protected static ?string $model = InterestedParty::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InterestedPartyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterestedPartiesTable::configure($table);
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
            'index' => ListInterestedParties::route('/'),
            'create' => CreateInterestedParty::route('/create'),
            'edit' => EditInterestedParty::route('/{record}/edit'),
        ];
    }
}
