<?php

namespace App\Filament\Resources\QualityObjectives;

use App\Filament\Resources\QualityObjectives\Pages;
use App\Models\QualityObjective;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use UnitEnum;
use Filament\Resources\Resource;

class QualityObjectiveResource extends Resource
{
    protected static ?string $model = QualityObjective::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 80;

    protected static ?string $navigationLabel = 'Quality Objectives & KPIs';

    protected static ?string $modelLabel = 'Quality Objective';

    protected static ?string $pluralModelLabel = 'Quality Objectives & KPIs';

    public static function canViewAny(): bool
    {
        return Gate::allows('quality-objectives.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('quality-objectives.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('quality-objectives.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('quality-objectives.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Objective Information')
                ->schema([
                    TextInput::make('objective_code')
                        ->label('Objective Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Objective Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('description')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('related_process')
                        ->label('Related QMS Process')
                        ->maxLength(255),

                    Select::make('status')
                        ->options([
                            'Draft' => 'Draft',
                            'Approved' => 'Approved',
                            'In Progress' => 'In Progress',
                            'Achieved' => 'Achieved',
                            'Not Achieved' => 'Not Achieved',
                            'Under Review' => 'Under Review',
                            'Closed' => 'Closed',
                        ])
                        ->default('Draft')
                        ->required(),
                ])
                ->columns(2),

            Section::make('Key Performance Indicator (KPI)')
                ->schema([
                    TextInput::make('kpi_name')
                        ->label('KPI Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('measurement_method')
                        ->label('Measurement Method')
                        ->maxLength(255),

                    TextInput::make('unit_of_measure')
                        ->label('Unit of Measure')
                        ->placeholder('%, number, days, TSh'),

                    TextInput::make('baseline_value')
                        ->numeric()
                        ->label('Baseline Value'),

                    TextInput::make('target_value')
                        ->numeric()
                        ->required()
                        ->label('Target Value'),

                    TextInput::make('actual_value')
                        ->numeric()
                        ->label('Actual Result'),

                    Select::make('measurement_frequency')
                        ->options([
                            'Monthly' => 'Monthly',
                            'Quarterly' => 'Quarterly',
                            'Semi-Annually' => 'Semi-Annually',
                            'Annually' => 'Annually',
                        ])
                        ->default('Quarterly')
                        ->required(),

                    TextInput::make('progress_percentage')
                        ->label('Progress (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->required(),
                ])
                ->columns(2),

            Section::make('Responsibility and Review')
                ->schema([
                    TextInput::make('responsible_person')
                        ->label('Responsible Person / Department')
                        ->maxLength(255),

                    DatePicker::make('start_date'),

                    DatePicker::make('due_date'),

                    DatePicker::make('last_review_date'),

                    \Filament\Forms\Components\Textarea::make('review_notes')
                        ->label('Review Notes / Evidence')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('objective_code')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('kpi_name')
                    ->label('KPI')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('target_value')
                    ->label('Target')
                    ->numeric(decimalPlaces: 2),

                TextColumn::make('actual_value')
                    ->label('Actual')
                    ->numeric(decimalPlaces: 2),

                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable(),

                TextColumn::make('responsible_person')
                    ->label('Responsible')
                    ->searchable(),

                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Achieved' => 'success',
                        'Approved', 'In Progress' => 'info',
                        'Not Achieved' => 'danger',
                        'Under Review' => 'warning',
                        'Closed' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQualityObjectives::route('/'),
            'create' => Pages\CreateQualityObjective::route('/create'),
            'edit' => Pages\EditQualityObjective::route('/{record}/edit'),
        ];
    }
}
