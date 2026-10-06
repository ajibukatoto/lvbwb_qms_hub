<?php

namespace App\Filament\Resources\QmsScopes;

use App\Filament\Resources\QmsScopes\Pages\CreateQmsScope;
use App\Filament\Resources\QmsScopes\Pages\EditQmsScope;
use App\Filament\Resources\QmsScopes\Pages\ListQmsScopes;
use App\Filament\Resources\QmsScopes\Schemas\QmsScopeForm;
use App\Filament\Resources\QmsScopes\Tables\QmsScopesTable;
use App\Models\QmsScope;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class QmsScopeResource extends Resource
{
    protected static ?string $model = QmsScope::class;

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-globe-europe-africa';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'QMS Scope';

    protected static ?string $modelLabel = 'QMS Scope';

    protected static ?string $pluralModelLabel = 'QMS Scopes';

    public static function form(Schema $schema): Schema
    {
        return QmsScopeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QmsScopesTable::configure($table);
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('qms-context.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('qms-context.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('qms-context.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('qms-context.delete');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQmsScopes::route('/'),
            'create' => CreateQmsScope::route('/create'),
            'edit' => EditQmsScope::route('/{record}/edit'),
        ];
    }
}

