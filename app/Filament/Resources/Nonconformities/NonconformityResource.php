<?php

namespace App\Filament\Resources\Nonconformities;

use App\Filament\Resources\Nonconformities\Pages;
use App\Models\Nonconformity;
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
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class NonconformityResource extends Resource
{
    protected static ?string $model = Nonconformity::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 110;

    protected static ?string $navigationLabel = 'Nonconformities (NCR)';

    protected static ?string $modelLabel = 'Nonconformity';

    protected static ?string $pluralModelLabel = 'Nonconformities';

    public static function canViewAny(): bool
    {
        return Gate::allows('nonconformities.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('nonconformities.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('nonconformities.update')
            || Gate::allows('nonconformities.close');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('nonconformities.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Nonconformity Identification')
                ->schema([
                    TextInput::make('ncr_reference')
                        ->label('NCR Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Nonconformity Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('source')
                        ->label('Source of Nonconformity')
                        ->options([
                            'Internal Audit' => 'Internal Audit',
                            'External Audit' => 'External Audit',
                            'Customer Complaint' => 'Customer Complaint',
                            'Process Monitoring' => 'Process Monitoring',
                            'Management Review' => 'Management Review',
                            'Inspection' => 'Inspection',
                            'Other' => 'Other',
                        ])
                        ->default('Internal Audit')
                        ->required(),

                    Select::make('audit_finding_id')
                        ->label('Related Audit Finding (Optional)')
                        ->relationship('auditFinding', 'finding_reference')
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    TextInput::make('department_or_process')
                        ->label('Department / Process')
                        ->required()
                        ->maxLength(255),

                    Select::make('severity')
                        ->options([
                            'Major' => 'Major',
                            'Minor' => 'Minor',
                        ])
                        ->default('Minor')
                        ->required(),

                    TextInput::make('iso_clause')
                        ->label('Applicable ISO Clause')
                        ->placeholder('e.g. 7.1.5 or 8.5.1')
                        ->maxLength(100),

                    DatePicker::make('identified_date')
                        ->label('Date Identified')
                        ->required()
                        ->default(now()->toDateString()),

                    \Filament\Forms\Components\Textarea::make('nonconformity_description')
                        ->label('Description of Nonconformity')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('objective_evidence')
                        ->label('Objective Evidence')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Immediate Correction and Responsibility')
                ->schema([
                    \Filament\Forms\Components\Textarea::make('immediate_correction')
                        ->label('Immediate Correction / Containment')
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('responsible_person')
                        ->label('Responsible Person / Department')
                        ->maxLength(255),

                    DatePicker::make('target_resolution_date')
                        ->label('Target Resolution Date'),
                ])
                ->columns(2),

            Section::make('Review and Closure')
                ->schema([
                    Select::make('status')
                        ->options([
                            'Open' => 'Open',
                            'Under Review' => 'Under Review',
                            'Correction in Progress' => 'Correction in Progress',
                            'Awaiting Verification' => 'Awaiting Verification',
                            'Closed' => 'Closed',
                            'Rejected' => 'Rejected',
                        ])
                        ->default('Open')
                        ->required(),

                    DatePicker::make('closed_date')
                        ->label('Closure Date'),

                    TextInput::make('verified_by')
                        ->label('Verified By')
                        ->maxLength(255),

                    \Filament\Forms\Components\Textarea::make('review_notes')
                        ->label('Review Notes')
                        ->rows(3)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('closure_evidence')
                        ->label('Closure Evidence')
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
                TextColumn::make('ncr_reference')
                    ->label('NCR Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Nonconformity')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('source')
                    ->badge(),

                TextColumn::make('department_or_process')
                    ->label('Department / Process')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('severity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Major' => 'danger',
                        'Minor' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('identified_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('responsible_person')
                    ->label('Responsible')
                    ->searchable(),

                TextColumn::make('target_resolution_date')
                    ->label('Target Resolution')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Closed' => 'success',
                        'Correction in Progress' => 'info',
                        'Awaiting Verification' => 'warning',
                        'Rejected' => 'danger',
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
            'index' => Pages\ListNonconformities::route('/'),
            'create' => Pages\CreateNonconformity::route('/create'),
            'edit' => Pages\EditNonconformity::route('/{record}/edit'),
        ];
    }
}
