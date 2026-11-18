<?php

namespace App\Filament\Resources\AuditFindings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class AuditFindingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Audit Finding Identification')
                    ->schema([

                        TextInput::make('title')
                            ->label('Finding Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('finding_type')
                            ->label('Finding Type')
                            ->options([
                                'Major Nonconformity' => 'Major Nonconformity',
                                'Minor Nonconformity' => 'Minor Nonconformity',
                                'Observation' => 'Observation',
                                'Opportunity for Improvement' => 'Opportunity for Improvement',
                            ])
                            ->required(),

                        TextInput::make('iso_clause')
                            ->label('Applicable ISO Clause')
                            ->placeholder('e.g. 7.1.5 or 8.5.1')
                            ->maxLength(100),

                        Textarea::make('description')
                            ->label('Finding Description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('objective_evidence')
                            ->label('Objective Evidence')
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('recommendation')
                            ->label('Recommendation')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Audit and Responsibility')
                    ->schema([

                        TextInput::make('internal_audit_id')
                            ->label('Internal Audit ID')
                            ->numeric(),

                        TextInput::make('responsible_person')
                            ->label('Responsible Person')
                            ->maxLength(255),

                        DatePicker::make('target_date')
                            ->label('Target Completion Date'),

                        Select::make('status')
                            ->options([
                                'Open' => 'Open',
                                'In Progress' => 'In Progress',
                                'Resolved' => 'Resolved',
                                'Closed' => 'Closed',
                            ])
                            ->default('Open')
                            ->required(),

                    ])
                    ->columns(2),

            ]);
    }
}
