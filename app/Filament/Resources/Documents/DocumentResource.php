<?php

namespace App\Filament\Resources\Documents;

use App\Filament\Resources\Documents\Pages;
use App\Models\Document;
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

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static string | \BackedEnum | null $navigationIcon =
        'heroicon-o-folder';

    protected static string | \UnitEnum | null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 60;

    protected static ?string $navigationLabel = 'Document Control';

    protected static ?string $modelLabel = 'Document';

    protected static ?string $pluralModelLabel = 'Documents';

    public static function canViewAny(): bool
    {
        return Gate::allows('documents.view');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('documents.create');
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('documents.update');
    }

    public static function canDelete(Model $record): bool
    {
        return Gate::allows('documents.delete');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Document Information')
                ->schema([
                    TextInput::make('document_code')
                        ->label('Document Code')
                        ->placeholder('e.g. LVBWB-QMS-PRO-001')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true),

                    TextInput::make('title')
                        ->label('Document Title')
                        ->required()
                        ->maxLength(255),

                    Select::make('category')
                        ->label('Document Category')
                        ->options([
                            'policy' => 'Policy',
                            'procedure' => 'Procedure',
                            'work_instruction' => 'Work Instruction',
                            'form' => 'Form / Template',
                            'manual' => 'Manual',
                            'record' => 'Record',
                            'audit_evidence' => 'Audit Evidence',
                            'report' => 'Report',
                            'external_document' => 'External Document',
                            'other' => 'Other',
                        ])
                        ->searchable()
                        ->required(),

                    TextInput::make('version')
                        ->label('Version')
                        ->default('1.0')
                        ->required()
                        ->maxLength(30),

                    Select::make('status')
                        ->label('Document Status')
                        ->options([
                            'draft' => 'Draft',
                            'under_review' => 'Under Review',
                            'obsolete' => 'Obsolete',
                        ])
                        ->default('draft')
                        ->required()
                        ->helperText(
                            'Approval and publishing will be handled through controlled workflow actions.'
                        ),

                    DatePicker::make('effective_date')
                        ->label('Effective Date')
                        ->native(false),

                    DatePicker::make('review_date')
                        ->label('Next Review Date')
                        ->native(false),

                    Textarea::make('description')
                        ->label('Description / Purpose')
                        ->rows(4)
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Document File')
                ->schema([
                    FileUpload::make('file_path')
                        ->label('Upload Document')
                        ->disk('local')
                        ->directory('qms/documents')
                        ->visibility('private')
                        ->storeFileNamesIn('original_file_name')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'image/jpeg',
                            'image/png',
                        ])
                        ->maxSize(20480)
                        ->helperText(
                            'Accepted: PDF, Word, Excel, JPG and PNG. Maximum size: 20 MB.'
                        )
                        ->columnSpanFull(),

                    Textarea::make('approval_comments')
                        ->label('Review / Approval Comments')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_code')
                    ->label('Document Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Document Title')
                    ->searchable()
                    ->limit(45),

                TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'work_instruction' => 'Work Instruction',
                            'audit_evidence' => 'Audit Evidence',
                            'external_document' => 'External Document',
                            default => ucfirst(str_replace('_', ' ', $state)),
                        }
                    ),

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
                            'obsolete' => 'Obsolete',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'draft' => 'gray',
                            'under_review' => 'warning',
                            'approved', 'published' => 'success',
                            'obsolete' => 'danger',
                            default => 'gray',
                        }
                    ),

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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
