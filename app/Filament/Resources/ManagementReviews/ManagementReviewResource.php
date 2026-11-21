<?php

namespace App\Filament\Resources\ManagementReviews;

use App\Filament\Resources\ManagementReviews\Pages;
use App\Models\ManagementReview;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
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

class ManagementReviewResource extends Resource
{
    protected static ?string $model = ManagementReview::class;

    protected static string|BackedEnum|null $navigationIcon =
        'heroicon-o-clipboard-document-check';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 130;

    protected static ?string $navigationLabel = 'Management Review';

    protected static ?string $modelLabel = 'Management Review';

    protected static ?string $pluralModelLabel = 'Management Reviews';

    public static function canViewAny(): bool
    {
        return Gate::allows('management-reviews.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('management-reviews.create');
    }

    public static function canEdit($record): bool
    {
        return Gate::allows('management-reviews.update');
    }

    public static function canDelete($record): bool
    {
        return Gate::allows('management-reviews.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            // SECTION 1: MEETING IDENTIFICATION

            Section::make('Management Review Identification')
                ->description('Basic information about the management review meeting.')
                ->schema([

                    TextInput::make('review_reference')
                        ->label('Review Reference')
                        ->placeholder('MR-2026-001')
                        ->required()
                        ->maxLength(50)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Meeting Title')
                        ->required()
                        ->maxLength(255),

                    DatePicker::make('meeting_date')
                        ->label('Meeting Date')
                        ->required(),

                    TextInput::make('start_time')
                        ->label('Start Time')
                        ->placeholder('09:00 AM'),

                    TextInput::make('end_time')
                        ->label('End Time')
                        ->placeholder('12:00 PM'),

                    TextInput::make('venue')
                        ->label('Meeting Venue')
                        ->maxLength(255),

                    TextInput::make('chairperson')
                        ->label('Chairperson')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('prepared_by')
                        ->label('Prepared By')
                        ->maxLength(255),

                    Textarea::make('attendees')
                        ->label('Meeting Attendees')
                        ->placeholder('Enter names and positions of attendees.')
                        ->rows(4)
                        ->columnSpanFull(),

                    Select::make('status')
                        ->label('Meeting Status')
                        ->options([
                            'Planned' => 'Planned',
                            'Ongoing' => 'Ongoing',
                            'Completed' => 'Completed',
                            'Cancelled' => 'Cancelled',
                        ])
                        ->default('Planned')
                        ->required(),

                ])
                ->columns(2),

            // SECTION 2: MANAGEMENT REVIEW AGENDA

            Section::make('Management Review Agenda')
                ->schema([

                    Textarea::make('agenda')
                        ->label('Meeting Agenda')
                        ->placeholder('Enter the agenda items for the meeting.')
                        ->rows(5)
                        ->columnSpanFull(),

                ]),

            // SECTION 3: MANAGEMENT REVIEW INPUTS

            Section::make('Management Review Inputs')
                ->description('Information to be considered during the review.')
                ->schema([

                    Textarea::make('previous_actions_status')
                        ->label('1. Status of Previous Management Review Actions')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('changes_in_internal_external_issues')
                        ->label('2. Changes in Internal and External Issues')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('customer_satisfaction')
                        ->label('3. Customer Satisfaction and Feedback')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('quality_objectives_performance')
                        ->label('4. Quality Objectives Performance')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('process_performance')
                        ->label('5. Process Performance and Service Conformity')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('nonconformities_corrective_actions')
                        ->label('6. Nonconformities and Corrective Actions')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('audit_results')
                        ->label('7. Internal and External Audit Results')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('risks_opportunities')
                        ->label('8. Risks and Opportunities')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('resource_adequacy')
                        ->label('9. Adequacy of Resources')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('improvement_opportunities')
                        ->label('10. Opportunities for Improvement')
                        ->rows(3)
                        ->columnSpanFull(),

                ])
                ->columns(2),

            // SECTION 4: MANAGEMENT REVIEW OUTPUTS

            Section::make('Management Review Outputs')
                ->description('Decisions and actions resulting from the review.')
                ->schema([

                    Textarea::make('decisions')
                        ->label('Management Decisions')
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('resource_requirements')
                        ->label('Resource Requirements')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('improvement_decisions')
                        ->label('Improvement Decisions')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('qms_changes')
                        ->label('Required Changes to the QMS')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('overall_conclusion')
                        ->label('Overall Management Review Conclusion')
                        ->rows(4)
                        ->columnSpanFull(),

                ]),

            // SECTION 5: ACTION ITEMS

            Section::make('Management Review Action Items')
                ->description('Assign responsibilities and monitor implementation of decisions.')
                ->schema([

                    Repeater::make('actions')
                        ->relationship()
                        ->label('Action Items')
                        ->schema([

                            TextInput::make('action_reference')
                                ->label('Action Reference')
                                ->maxLength(50),

                            TextInput::make('action_title')
                                ->label('Action Title')
                                ->required()
                                ->maxLength(255),

                            Textarea::make('action_description')
                                ->label('Action Description')
                                ->rows(3)
                                ->columnSpanFull(),

                            TextInput::make('responsible_person')
                                ->label('Responsible Person')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('responsible_department')
                                ->label('Responsible Department')
                                ->maxLength(255),

                            DatePicker::make('due_date')
                                ->label('Due Date'),

                            DatePicker::make('completion_date')
                                ->label('Completion Date'),

                            Select::make('status')
                                ->label('Action Status')
                                ->options([
                                    'Open' => 'Open',
                                    'In Progress' => 'In Progress',
                                    'Completed' => 'Completed',
                                    'On Hold' => 'On Hold',
                                    'Cancelled' => 'Cancelled',
                                ])
                                ->default('Open')
                                ->required(),

                            Textarea::make('evidence_of_completion')
                                ->label('Evidence of Completion')
                                ->rows(3)
                                ->columnSpanFull(),

                            Textarea::make('remarks')
                                ->label('Action Remarks')
                                ->rows(2)
                                ->columnSpanFull(),

                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('Add Management Review Action')
                        ->collapsible()
                        ->columnSpanFull(),

                ]),

            // SECTION 6: APPROVAL AND REMARKS

            Section::make('Approval and Final Remarks')
                ->schema([

                    TextInput::make('approved_by')
                        ->label('Approved By')
                        ->maxLength(255),

                    DatePicker::make('approval_date')
                        ->label('Approval Date'),

                    Textarea::make('remarks')
                        ->label('Additional Remarks')
                        ->rows(4)
                        ->columnSpanFull(),

                ])
                ->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('review_reference')
                    ->label('Reference')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Meeting Title')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('meeting_date')
                    ->label('Meeting Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('chairperson')
                    ->label('Chairperson')
                    ->searchable(),

                TextColumn::make('actions_count')
                    ->label('Action Items')
                    ->counts('actions'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Completed' => 'success',
                        'Ongoing' => 'info',
                        'Cancelled' => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->defaultSort('meeting_date', 'desc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManagementReviews::route('/'),
            'create' => Pages\CreateManagementReview::route('/create'),
            'edit' => Pages\EditManagementReview::route('/{record}/edit'),
        ];
    }
}
