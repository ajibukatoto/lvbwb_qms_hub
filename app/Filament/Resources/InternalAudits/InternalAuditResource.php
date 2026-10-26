<?php

namespace App\Filament\Resources\InternalAudits;

use App\Filament\Resources\InternalAudits\Pages;
use App\Models\InternalAudit;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class InternalAuditResource extends Resource
{
    protected static ?string $model = InternalAudit::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 90;

    protected static ?string $navigationLabel = 'Internal Audits';

    protected static ?string $modelLabel = 'Internal Audit';

    protected static ?string $pluralModelLabel = 'Internal Audits';

    public static function canViewAny(): bool
    {
        return Gate::allows('audits.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('audits.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('audits.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('audits.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Audit Information')
                ->schema([
                    TextInput::make('audit_reference')
                        ->label('Audit Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Audit Title')
                        ->required()
                        ->maxLength(255),

                    Select::make('audit_type')
                        ->options([
                            'System Audit' => 'System Audit',
                            'Process Audit' => 'Process Audit',
                            'Department Audit' => 'Department Audit',
                            'Follow-up Audit' => 'Follow-up Audit',
                        ])
                        ->default('Process Audit')
                        ->required(),

                    TextInput::make('department_or_process')
                        ->label('Department / Process')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\Textarea::make('objective')
                        ->label('Audit Objective')
                        ->required()
                        ->rows(3),

                    \Filament\Forms\Components\Textarea::make('scope')
                        ->label('Audit Scope')
                        ->required()
                        ->rows(3),

                    \Filament\Forms\Components\Textarea::make('criteria')
                        ->label('Audit Criteria')
                        ->required()
                        ->rows(3),
                ])
                ->columns(2),

            Section::make('Audit Team and Schedule')
                ->schema([
                    TextInput::make('lead_auditor')
                        ->label('Lead Auditor')
                        ->required()
                        ->maxLength(255),

                    \Filament\Forms\Components\Textarea::make('audit_team')
                        ->label('Audit Team Members')
                        ->rows(2),

                    DatePicker::make('planned_start_date')
                        ->label('Planned Start Date')
                        ->required(),

                    DatePicker::make('planned_end_date')
                        ->label('Planned End Date')
                        ->afterOrEqual('planned_start_date'),

                    DatePicker::make('actual_start_date')
                        ->label('Actual Start Date'),

                    DatePicker::make('actual_end_date')
                        ->label('Actual End Date')
                        ->afterOrEqual('actual_start_date'),
                ])
                ->columns(2),

            Section::make('Audit Execution and Report')
                ->schema([
                    Select::make('status')
                        ->options([
                            'Planned' => 'Planned',
                            'In Progress' => 'In Progress',
                            'Completed' => 'Completed',
                            'Report Issued' => 'Report Issued',
                            'Follow-up Required' => 'Follow-up Required',
                            'Closed' => 'Closed',
                            'Cancelled' => 'Cancelled',
                        ])
                        ->default('Planned')
                        ->required(),

                    DatePicker::make('report_date')
                        ->label('Report Date'),

                    \Filament\Forms\Components\Textarea::make('summary_of_results')
                        ->label('Summary of Results')
                        ->rows(4)
                        ->columnSpanFull(),

                    TextInput::make('report_location')
                        ->label('Report File Location / Reference')
                        ->maxLength(255)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('audit_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('audit_type')
                    ->badge(),

                TextColumn::make('department_or_process')
                    ->label('Department / Process')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('lead_auditor')
                    ->searchable(),

                TextColumn::make('planned_start_date')
                    ->label('Planned Start')
                    ->date()
                    ->sortable(),

                TextColumn::make('planned_end_date')
                    ->label('Planned End')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Completed', 'Report Issued', 'Closed' => 'success',
                        'In Progress' => 'info',
                        'Follow-up Required' => 'warning',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('planned_start_date', 'desc')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternalAudits::route('/'),
            'create' => Pages\CreateInternalAudit::route('/create'),
            'edit' => Pages\EditInternalAudit::route('/{record}/edit'),
        ];
    }
}
