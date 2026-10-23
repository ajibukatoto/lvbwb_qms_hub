<?php

namespace App\Filament\Resources\RiskOpportunities;

use App\Filament\Resources\RiskOpportunities\Pages\CreateRiskOpportunity;
use App\Filament\Resources\RiskOpportunities\Pages\EditRiskOpportunity;
use App\Filament\Resources\RiskOpportunities\Pages\ListRiskOpportunities;
use App\Filament\Resources\RiskOpportunities\Schemas\RiskOpportunityForm;
use App\Filament\Resources\RiskOpportunities\Tables\RiskOpportunitiesTable;
use App\Models\RiskOpportunity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiskOpportunityResource extends Resource
{
    protected static ?string $model = RiskOpportunity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RiskOpportunityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RiskOpportunitiesTable::configure($table);
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
            'index' => ListRiskOpportunities::route('/'),
            'create' => CreateRiskOpportunity::route('/create'),
            'edit' => EditRiskOpportunity::route('/{record}/edit'),
        ];
    }
}
