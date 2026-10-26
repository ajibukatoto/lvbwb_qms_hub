<?php

namespace App\Filament\Resources\InternalAudits;

use App\Filament\Resources\InternalAudits\Pages\CreateInternalAudit;
use App\Filament\Resources\InternalAudits\Pages\EditInternalAudit;
use App\Filament\Resources\InternalAudits\Pages\ListInternalAudits;
use App\Filament\Resources\InternalAudits\Schemas\InternalAuditForm;
use App\Filament\Resources\InternalAudits\Tables\InternalAuditsTable;
use App\Models\InternalAudit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternalAuditResource extends Resource
{
    protected static ?string $model = InternalAudit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InternalAuditForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalAuditsTable::configure($table);
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
            'index' => ListInternalAudits::route('/'),
            'create' => CreateInternalAudit::route('/create'),
            'edit' => EditInternalAudit::route('/{record}/edit'),
        ];
    }
}
