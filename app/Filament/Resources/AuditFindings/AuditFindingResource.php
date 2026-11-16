<?php

namespace App\Filament\Resources\AuditFindings;

use App\Filament\Resources\AuditFindings\Pages;
use App\Models\AuditFinding;
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

class AuditFindingResource extends Resource
{
    protected static ?string $model = AuditFinding::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 100;

    protected static ?string $navigationLabel = 'Audit Findings';

    protected static ?string $modelLabel = 'Audit Finding';

    protected static ?string $pluralModelLabel = 'Audit Findings';

    public static function canViewAny(): bool
    {
        return Gate::allows('audit-findings.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('audit-findings.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('audit-findings.update')
            || Gate::allows('audit-findings.close');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Finding Information')
                ->schema([
                    TextInput::make('finding_reference')
                        ->label('Finding Reference')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    Select::make('internal_audit_id')
                        ->label('Related Internal Audit')
                        ->relationship('internalAudit', 'audit_reference')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('finding_title')
                        ->label('Finding Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('finding_type')
                        ->label('Finding Classification')
                        ->options([
                            'Major NC' => 'Major Nonconformity',
                            'Minor NC' => 'Minor Nonconformity',
                            'Observation' => 'Observation',
                            'OFI' => 'Opportunity for Improvement',
                        ])
                        ->required()
                        ->default('Observation'),

                    TextInput::make('iso_clause')
                        ->label('ISO 9001:2015 Clause')
                        ->placeholder('e.g. 7.1.5 or 8.5.1')
                        ->maxLength(100),

                    \Filament\Forms\Components\Textarea::make('finding_description')
                        ->label('Finding Description')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('objective_evidence')
                        ->label('Objective Evidence')
                        ->rows(4)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('requirement')
                        ->label('Applicable Requirement')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Corrective Action and Responsibility')
                ->schema([
                    \Filament\Forms\Components\Textarea::make('corrective_action_required')
                        ->label('Required Corrective Action')
                        ->rows(3)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('root_cause')
                        ->label('Root Cause Analysis')
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('responsible_person')
                        ->label('Responsible Person / Department')
                        ->maxLength(255),

                    DatePicker::make('target_closure_date')
                        ->label('Target Closure Date'),
                ])
                ->columns(2),

            Section::make('Finding Status and Closure')
                ->schema([
                    Select::make('status')
                        ->options([
                            'Open' => 'Open',
                            'Action Assigned' => 'Action Assigned',
                            'In Progress' => 'In Progress',
                            'Pending Verification' => 'Pending Verification',
                            'Closed' => 'Closed',
                            'Overdue' => 'Overdue',
                        ])
                        ->default('Open')
                        ->required(),

                    DatePicker::make('closed_at')
                        ->label('Closure Date'),

                    TextInput::make('verified_by')
                        ->label('Verified By')
                        ->maxLength(255),

                    \Filament\Forms\Components\Textarea::make('closure_evidence')
                        ->label('Closure Evidence')
                        ->rows(3)
                        ->columnSpanFull(),

                    \Filament\Forms\Components\Textarea::make('verification_notes')
                        ->label('Verification / Effectiveness Notes')
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
                TextColumn::make('finding_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('internalAudit.audit_reference')
                    ->label('Audit Reference')
                    ->searchable(),

                TextColumn::make('finding_title')
                    ->label('Finding')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('finding_type')
                    ->label('Classification')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Major NC' => 'danger',
                        'Minor NC' => 'warning',
                        'Observation' => 'info',
                        'OFI' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('iso_clause')
                    ->label('ISO Clause'),

                TextColumn::make('responsible_person')
                    ->label('Responsible')
                    ->searchable(),

                TextColumn::make('target_closure_date')
                    ->label('Target Closure')
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Closed' => 'success',
                        'In Progress', 'Action Assigned' => 'info',
                        'Pending Verification' => 'warning',
                        'Overdue' => 'danger',
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
            'index' => Pages\ListAuditFindings::route('/'),
            'create' => Pages\CreateAuditFinding::route('/create'),
            'edit' => Pages\EditAuditFinding::route('/{record}/edit'),
        ];
    }
}
