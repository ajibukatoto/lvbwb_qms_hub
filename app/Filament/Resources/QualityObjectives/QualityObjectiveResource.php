<?php

namespace App\Filament\Resources\QualityObjectives;

use App\Filament\Resources\QualityObjectives\Pages\CreateQualityObjective;
use App\Filament\Resources\QualityObjectives\Pages\EditQualityObjective;
use App\Filament\Resources\QualityObjectives\Pages\ListQualityObjectives;
use App\Filament\Resources\QualityObjectives\Schemas\QualityObjectiveForm;
use App\Filament\Resources\QualityObjectives\Tables\QualityObjectivesTable;
use App\Models\QualityObjective;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QualityObjectiveResource extends Resource
{
    protected static ?string $model = QualityObjective::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QualityObjectiveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QualityObjectivesTable::configure($table);
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
            'index' => ListQualityObjectives::route('/'),
            'create' => CreateQualityObjective::route('/create'),
            'edit' => EditQualityObjective::route('/{record}/edit'),
        ];
    }
}
