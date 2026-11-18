<?php

namespace App\Filament\Resources\Nonconformities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NonconformityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

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
                            ->options([])
                            ->searchable()
                            ->nullable(),

                        TextInput::make('department_or_process')
                            ->label('Department / Process')
                            ->required()
                            ->maxLength(255),

                        Select::make('severity')
                            ->label('Severity')
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

                        Textarea::make('nonconformity_description')
                            ->label('Description of Nonconformity')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Textarea::make('objective_evidence')
                            ->label('Objective Evidence')
                            ->rows(4)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Immediate Correction and Responsibility')
                    ->schema([

                        Textarea::make('immediate_correction')
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

                        Textarea::make('review_notes')
                            ->label('Review Notes')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('closure_evidence')
                            ->label('Closure Evidence')
                            ->rows(3)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

            ]);
    }
}
