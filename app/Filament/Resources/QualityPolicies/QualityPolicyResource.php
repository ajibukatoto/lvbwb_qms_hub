<?php

namespace App\Filament\Resources\QualityPolicies;

use App\Filament\Resources\QualityPolicies\Pages\CreateQualityPolicy;
use App\Filament\Resources\QualityPolicies\Pages\EditQualityPolicy;
use App\Filament\Resources\QualityPolicies\Pages\ListQualityPolicies;
use App\Filament\Resources\QualityPolicies\Schemas\QualityPolicyForm;
use App\Filament\Resources\QualityPolicies\Tables\QualityPoliciesTable;
use App\Models\QualityPolicy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QualityPolicyResource extends Resource
{
    protected static ?string $model = QualityPolicy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QualityPolicyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QualityPoliciesTable::configure($table);
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
            'index' => ListQualityPolicies::route('/'),
            'create' => CreateQualityPolicy::route('/create'),
            'edit' => EditQualityPolicy::route('/{record}/edit'),
        ];
    }
}
