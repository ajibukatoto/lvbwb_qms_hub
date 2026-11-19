<?php

namespace App\Filament\Resources\CorrectiveActions;

use App\Filament\Resources\CorrectiveActions\Pages;
use App\Models\CorrectiveAction;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class CorrectiveActionResource extends Resource
{
    protected static ?string $model = CorrectiveAction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 120;

    protected static ?string $navigationLabel = 'Corrective Actions (CAPA)';

    protected static ?string $modelLabel = 'Corrective Action';

    protected static ?string $pluralModelLabel = 'Corrective Actions';

    public static function canViewAny(): bool
    {
        return Gate::allows('corrective-actions.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('corrective-actions.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('corrective-actions.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('corrective-actions.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('CAPA Identification')
                ->schema([
                    TextInput::make('capa_reference')
                        ->label('CAPA Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Corrective Action Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('nonconformity_id')
                        ->label('Related Nonconformity (NCR)')
                        ->relationship('nonconformity', 'ncr_reference')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    TextInput::make('responsible_person')
                        ->label('Responsible Person')
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Root Cause Analysis')
                ->schema([
                    Textarea::make('root_cause')
                        ->label('Root Cause Analysis')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('correction')
                        ->label('Immediate Correction')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('corrective_action')
                        ->label('Corrective Action Plan')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('preventive_action')
                        ->label('Preventive Action')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Implementation')
                ->schema([
                    DatePicker::make('planned_completion_date')
                        ->label('Planned Completion Date'),

                    DatePicker::make('actual_completion_date')
                        ->label('Actual Completion Date'),

                    Select::make('status')
                        ->options([
                            'Open' => 'Open',
                            'Root Cause Analysis' => 'Root Cause Analysis',
                            'Action Planned' => 'Action Planned',
                            'In Progress' => 'In Progress',
                            'Awaiting Verification' => 'Awaiting Verification',
                            'Effective' => 'Effective',
                            'Ineffective' => 'Ineffective',
                            'Closed' => 'Closed',
                        ])
                        ->default('Open')
                        ->required(),

                    Textarea::make('remarks')
                        ->label('Implementation Remarks')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Verification and Effectiveness')
                ->schema([
                    Textarea::make('verification_method')
                        ->label('Verification Method')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('verification_results')
                        ->label('Verification Results')
                        ->rows(3)
                        ->columnSpanFull(),

                    Select::make('effectiveness')
                        ->label('Effectiveness')
                        ->options([
                            'Effective' => 'Effective',
                            'Ineffective' => 'Ineffective',
                            'Pending' => 'Pending',
                        ])
                        ->nullable(),

                    DatePicker::make('verification_date')
                        ->label('Verification Date'),

                    TextInput::make('verified_by')
                        ->label('Verified By')
                        ->maxLength(255),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('capa_reference')
                    ->label('CAPA Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Corrective Action')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('nonconformity.ncr_reference')
                    ->label('Related NCR')
                    ->placeholder('Not linked'),

                TextColumn::make('responsible_person')
                    ->label('Responsible')
                    ->searchable(),

                TextColumn::make('planned_completion_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('effectiveness')
                    ->badge()
                    ->placeholder('Pending'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCorrectiveActions::route('/'),
            'create' => Pages\CreateCorrectiveAction::route('/create'),
            'edit' => Pages\EditCorrectiveAction::route('/{record}/edit'),
        ];
    }
}
