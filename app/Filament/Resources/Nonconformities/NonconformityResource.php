<?php

namespace App\Filament\Resources\Nonconformities;

use App\Filament\Resources\Nonconformities\Pages\CreateNonconformity;
use App\Filament\Resources\Nonconformities\Pages\EditNonconformity;
use App\Filament\Resources\Nonconformities\Pages\ListNonconformities;
use App\Filament\Resources\Nonconformities\Schemas\NonconformityForm;
use App\Filament\Resources\Nonconformities\Tables\NonconformitiesTable;
use App\Models\Nonconformity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NonconformityResource extends Resource
{
    protected static ?string $model = Nonconformity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return NonconformityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NonconformitiesTable::configure($table);
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
            'index' => ListNonconformities::route('/'),
            'create' => CreateNonconformity::route('/create'),
            'edit' => EditNonconformity::route('/{record}/edit'),
        ];
    }
}
