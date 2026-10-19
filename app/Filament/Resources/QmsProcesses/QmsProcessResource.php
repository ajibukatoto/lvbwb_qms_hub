<?php

namespace App\Filament\Resources\QmsProcesses;

use App\Filament\Resources\QmsProcesses\Pages\CreateQmsProcess;
use App\Filament\Resources\QmsProcesses\Pages\EditQmsProcess;
use App\Filament\Resources\QmsProcesses\Pages\ListQmsProcesses;
use App\Filament\Resources\QmsProcesses\Schemas\QmsProcessForm;
use App\Filament\Resources\QmsProcesses\Tables\QmsProcessesTable;
use App\Models\QmsProcess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QmsProcessResource extends Resource
{
    protected static ?string $model = QmsProcess::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QmsProcessForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QmsProcessesTable::configure($table);
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
            'index' => ListQmsProcesses::route('/'),
            'create' => CreateQmsProcess::route('/create'),
            'edit' => EditQmsProcess::route('/{record}/edit'),
        ];
    }
}
