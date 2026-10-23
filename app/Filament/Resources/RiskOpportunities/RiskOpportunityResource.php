<?php

namespace App\Filament\Resources\RiskOpportunities;

use App\Filament\Resources\RiskOpportunities\Pages;
use App\Models\RiskOpportunity;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class RiskOpportunityResource extends Resource
{
    protected static ?string $model = RiskOpportunity::class;

    protected static string | \BackedEnum | null $navigationIcon =
        'heroicon-o-shield-exclamation';

    protected static string | \UnitEnum | null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 70;

    protected static ?string $navigationLabel = 'Risks & Opportunities';

    protected static ?string $modelLabel = 'Risk / Opportunity';

    protected static ?string $pluralModelLabel = 'Risks & Opportunities';

    public static function canViewAny(): bool
    {
        return Gate::allows('risks.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('risks.create');
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('risks.update');
    }

    public static function canDelete(Model $record): bool
    {
        return Gate::allows('risks.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Risk / Opportunity Information')
                ->schema([
                    TextInput::make('reference_code')
                        ->label('Reference Code')
                        ->placeholder('e.g. LVBWB-RSK-001')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Select::make('type')
                        ->options([
                            'risk' => 'Risk',
                            'opportunity' => 'Opportunity',
                        ])
                        ->default('risk')
                        ->required(),

                    Select::make('category')
                        ->options([
                            'strategic' => 'Strategic',
                            'operational' => 'Operational',
                            'financial' => 'Financial',
                            'legal' => 'Legal / Compliance',
                            'environmental' => 'Environmental',
                            'technology' => 'Technology / ICT',
                            'human_resources' => 'Human Resources',
                            'service_delivery' => 'Service Delivery',
                            'other' => 'Other',
                        ])
                        ->searchable()
                        ->required(),

                    Textarea::make('description')
                        ->label('Description')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('potential_effect')
                        ->label('Potential Effect on QMS / Services')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Assessment')
                ->description(
                    'Rate likelihood and impact from 1 (lowest) to 5 (highest).'
                )
                ->schema([
                    Select::make('likelihood')
                        ->options([
                            1 => '1 - Very Low',
                            2 => '2 - Low',
                            3 => '3 - Moderate',
                            4 => '4 - High',
                            5 => '5 - Very High',
                        ])
                        ->default(3)
                        ->required(),

                    Select::make('impact')
                        ->options([
                            1 => '1 - Very Low',
                            2 => '2 - Low',
                            3 => '3 - Moderate',
                            4 => '4 - High',
                            5 => '5 - Very High',
                        ])
                        ->default(3)
                        ->required(),

                    Textarea::make('existing_controls')
                        ->label('Existing Controls')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('planned_actions')
                        ->label('Planned Treatment / Actions')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Responsibility and Monitoring')
                ->schema([
                    TextInput::make('responsible_person')
                        ->label('Responsible Person')
                        ->maxLength(255),

                    DatePicker::make('target_date')
                        ->label('Target Completion Date')
                        ->native(false),

                    Select::make('status')
                        ->options([
                            'identified' => 'Identified',
                            'under_review' => 'Under Review',
                            'action_planned' => 'Action Planned',
                            'in_progress' => 'In Progress',
                            'monitored' => 'Monitored',
                            'closed' => 'Closed',
                        ])
                        ->default('identified')
                        ->required(),

                    DatePicker::make('last_reviewed_at')
                        ->label('Last Review Date')
                        ->native(false),

                    Textarea::make('review_notes')
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
                TextColumn::make('reference_code')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string =>
                        $state === 'risk' ? 'danger' : 'success'
                    ),

                TextColumn::make('category')
                    ->badge(),

                TextColumn::make('likelihood')
                    ->label('Likelihood')
                    ->sortable(),

                TextColumn::make('impact')
                    ->label('Impact')
                    ->sortable(),

                TextColumn::make('risk_score')
                    ->label('Score')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 15 => 'danger',
                        $state >= 8 => 'warning',
                        default => 'success',
                    })
                    ->sortable(),

                TextColumn::make('responsible_person')
                    ->label('Responsible Person')
                    ->placeholder('Not assigned')
                    ->searchable(),

                TextColumn::make('target_date')
                    ->label('Target Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'closed', 'monitored' => 'success',
                        'in_progress', 'action_planned' => 'warning',
                        'under_review' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('risk_score', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiskOpportunities::route('/'),
            'create' => Pages\CreateRiskOpportunity::route('/create'),
            'edit' => Pages\EditRiskOpportunity::route('/{record}/edit'),
        ];
    }
}
