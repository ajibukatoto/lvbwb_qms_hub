<?php

namespace App\Filament\Resources\Trainings;

use App\Filament\Resources\Trainings\Pages;
use App\Models\Training;
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

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 130;

    protected static ?string $navigationLabel = 'Training & Competence';

    protected static ?string $modelLabel = 'Training';

    protected static ?string $pluralModelLabel = 'Training Records';

    public static function canViewAny(): bool
    {
        return Gate::allows('trainings.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('trainings.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('trainings.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('trainings.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Training Identification')
                ->schema([
                    TextInput::make('training_reference')
                        ->label('Training Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Training Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('training_type')
                        ->label('Training Type')
                        ->options([
                            'Internal' => 'Internal Training',
                            'External' => 'External Training',
                            'Workshop' => 'Workshop',
                            'Seminar' => 'Seminar',
                            'Online' => 'Online Training',
                            'On the Job' => 'On-the-Job Training',
                        ])
                        ->default('Internal')
                        ->required(),

                    TextInput::make('department')
                        ->label('Department / Unit')
                        ->maxLength(255),

                    Textarea::make('description')
                        ->label('Training Description')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Trainer and Schedule')
                ->schema([
                    TextInput::make('trainer')
                        ->label('Trainer / Facilitator')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('venue')
                        ->label('Training Venue')
                        ->maxLength(255),

                    DatePicker::make('start_date')
                        ->label('Start Date')
                        ->required(),

                    DatePicker::make('end_date')
                        ->label('End Date')
                        ->afterOrEqual('start_date'),

                    Select::make('status')
                        ->options([
                            'Planned' => 'Planned',
                            'Approved' => 'Approved',
                            'Ongoing' => 'Ongoing',
                            'Completed' => 'Completed',
                            'Cancelled' => 'Cancelled',
                        ])
                        ->default('Planned')
                        ->required(),
                ])
                ->columns(2),

            Section::make('Participants')
                ->schema([
                    Textarea::make('participants')
                        ->label('Participants Names')
                        ->placeholder('Enter participant names, one per line')
                        ->rows(5)
                        ->columnSpanFull(),

                    TextInput::make('number_of_participants')
                        ->label('Number of Participants')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),

                    TextInput::make('training_cost')
                        ->label('Training Cost (TZS)')
                        ->numeric()
                        ->minValue(0)
                        ->prefix('TZS'),
                ])
                ->columns(2),

            Section::make('Training Evaluation and Competence')
                ->schema([
                    Textarea::make('training_outcomes')
                        ->label('Training Outcomes')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('evaluation_results')
                        ->label('Training Evaluation Results')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('competence_assessment')
                        ->label('Competence Assessment')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('remarks')
                        ->label('Additional Remarks')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('training_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Training Title')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('training_type')
                    ->label('Type')
                    ->badge(),

                TextColumn::make('department')
                    ->label('Department')
                    ->searchable(),

                TextColumn::make('trainer')
                    ->label('Trainer')
                    ->searchable(),

                TextColumn::make('start_date')
                    ->label('Start Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('number_of_participants')
                    ->label('Participants')
                    ->numeric(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Completed' => 'success',
                        'Ongoing' => 'info',
                        'Cancelled' => 'danger',
                        'Approved' => 'success',
                        default => 'warning',
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
            'index' => Pages\ListTrainings::route('/'),
            'create' => Pages\CreateTraining::route('/create'),
            'edit' => Pages\EditTraining::route('/{record}/edit'),
        ];
    }
}
