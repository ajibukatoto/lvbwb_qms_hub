<?php

namespace App\Filament\Resources\QualityPolicies;

use App\Filament\Resources\QualityPolicies\Pages;
use App\Models\QualityPolicy;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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

class QualityPolicyResource extends Resource
{
    protected static ?string $model = QualityPolicy::class;

    protected static string | \BackedEnum | null $navigationIcon =
        'heroicon-o-document-check';

    protected static string | \UnitEnum | null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 50;

    protected static ?string $navigationLabel = 'Quality Policy';

    protected static ?string $modelLabel = 'Quality Policy';

    protected static ?string $pluralModelLabel = 'Quality Policies';

    public static function canViewAny(): bool
    {
        return Gate::allows('quality-policy.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('quality-policy.create');
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('quality-policy.update');
    }

    public static function canDelete(Model $record): bool
    {
        return Gate::allows('quality-policy.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Policy Information')
                ->schema([
                    TextInput::make('policy_code')
                        ->label('Policy Code')
                        ->placeholder('LVBWB-QMS-POL-001')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Policy Title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    TextInput::make('version')
                        ->label('Version')
                        ->default('1.0')
                        ->required()
                        ->maxLength(20),

                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'draft' => 'Draft',
                            'under_review' => 'Under Review',
                            'approved' => 'Approved',
                            'published' => 'Published',
                            'superseded' => 'Superseded',
                        ])
                        ->default('draft')
                        ->required(),

                    DatePicker::make('effective_date')
                        ->label('Effective Date')
                        ->native(false),

                    DatePicker::make('review_date')
                        ->label('Next Review Date')
                        ->native(false),

                    Textarea::make('policy_statement')
                        ->label('Quality Policy Statement')
                        ->required()
                        ->rows(8)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Approval and Supporting Document')
                ->schema([
                    Textarea::make('approval_comments')
                        ->label('Review / Approval Comments')
                        ->rows(3)
                        ->columnSpanFull(),

                    FileUpload::make('document_file')
                        ->label('Upload Policy Document')
                        ->disk('local')
                        ->directory('qms/quality-policies')
                        ->visibility('private')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ])
                        ->maxSize(10240)
                        ->helperText(
                            'Accepted formats: PDF and Word. Maximum size: 10 MB.'
                        )
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('policy_code')
                    ->label('Policy Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Policy Title')
                    ->searchable()
                    ->limit(45),

                TextColumn::make('version')
                    ->label('Version')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'draft' => 'Draft',
                            'under_review' => 'Under Review',
                            'approved' => 'Approved',
                            'published' => 'Published',
                            'superseded' => 'Superseded',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'draft' => 'gray',
                            'under_review' => 'warning',
                            'approved', 'published' => 'success',
                            'superseded' => 'danger',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('effective_date')
                    ->label('Effective Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('review_date')
                    ->label('Next Review')
                    ->date()
                    ->sortable(),

                TextColumn::make('preparedBy.name')
                    ->label('Prepared By')
                    ->placeholder('Not assigned'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQualityPolicies::route('/'),
            'create' => Pages\CreateQualityPolicy::route('/create'),
            'edit' => Pages\EditQualityPolicy::route('/{record}/edit'),
        ];
    }
}

