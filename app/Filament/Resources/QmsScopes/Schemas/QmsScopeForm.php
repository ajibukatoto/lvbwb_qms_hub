<?php

namespace App\Filament\Resources\QmsScopes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QmsScopeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('QMS Scope Information')
                    ->description(
                        'Define the boundaries and applicability of the LVBWB Quality Management System.'
                    )
                    ->schema([

                        TextInput::make('title')
                            ->label('Scope Title')
                            ->placeholder('e.g. LVBWB Quality Management System Scope')
                            ->required()
                            ->maxLength(255),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'superseded' => 'Superseded',
                            ])
                            ->default('draft')
                            ->required(),

                        Textarea::make('scope_statement')
                            ->label('QMS Scope Statement')
                            ->placeholder(
                                'Describe the activities, services, locations and organizational boundaries covered by the QMS.'
                            )
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Scope Boundaries')
                    ->schema([

                        Textarea::make('organizational_units')
                            ->label('Organizational Units')
                            ->placeholder(
                                'List departments, units, sections or offices covered by the QMS.'
                            )
                            ->rows(4),

                        Textarea::make('locations')
                            ->label('Locations')
                            ->placeholder(
                                'List locations, offices, branches or operational areas covered by the QMS.'
                            )
                            ->rows(4),

                        Textarea::make('services')
                            ->label('Services / Activities')
                            ->placeholder(
                                'Describe the services and activities covered by the QMS.'
                            )
                            ->rows(4),

                        Textarea::make('exclusions')
                            ->label('Exclusions / Non-applicable Requirements')
                            ->placeholder(
                                'Specify any ISO 9001 requirements that are determined to be not applicable, with justification.'
                            )
                            ->rows(4),

                    ])
                    ->columns(2),

                Section::make('Review & Approval')
                    ->schema([

                        DatePicker::make('effective_date')
                            ->label('Effective Date')
                            ->native(false),

                        DatePicker::make('review_date')
                            ->label('Next Review Date')
                            ->native(false),

                        Select::make('prepared_by')
                            ->label('Prepared By')
                            ->relationship('preparedBy', 'name')
                            ->searchable()
                            ->preload(),

                        Select::make('approved_by')
                            ->label('Approved By')
                            ->relationship('approvedBy', 'name')
                            ->searchable()
                            ->preload(),

                        Textarea::make('approval_comments')
                            ->label('Approval Comments')
                            ->rows(4)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

            ]);
    }
}
