<?php

namespace App\Filament\Resources\QmsProcesses;

use App\Filament\Resources\QmsProcesses\Pages\CreateQmsProcess;
use App\Filament\Resources\QmsProcesses\Pages\EditQmsProcess;
use App\Filament\Resources\QmsProcesses\Pages\ListQmsProcesses;
use App\Models\QmsProcess;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class QmsProcessResource extends Resource
{
    protected static ?string $model = QmsProcess::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 40;

    protected static ?string $navigationLabel = 'QMS Processes';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Process Information')
                ->schema([
                    TextInput::make('process_code')
                        ->label('Process Code')
                        ->placeholder('e.g. LVBWB-PRO-001')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(100),

                    TextInput::make('name')
                        ->label('Process Name')
                        ->required()
                        ->maxLength(255),

                    Select::make('process_type')
                        ->label('Process Type')
                        ->options([
                            'strategic' => 'Strategic',
                            'operational' => 'Operational',
                            'support' => 'Support',
                            'monitoring' => 'Monitoring and Evaluation',
                        ])
                        ->required()
                        ->default('operational'),

                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'active' => 'Active',
                            'under_review' => 'Under Review',
                            'inactive' => 'Inactive',
                        ])
                        ->required()
                        ->default('draft'),

                    TextInput::make('owner_name')
                        ->label('Process Owner')
                        ->maxLength(255),

                    Textarea::make('purpose')
                        ->label('Purpose of the Process')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('inputs')
                        ->label('Inputs')
                        ->rows(3),

                    Textarea::make('activities')
                        ->label('Main Activities')
                        ->rows(3),

                    Textarea::make('outputs')
                        ->label('Outputs')
                        ->rows(3),

                    Textarea::make('resources')
                        ->label('Required Resources')
                        ->rows(3),

                    Textarea::make('kpis')
                        ->label('KPIs / Performance Measures')
                        ->rows(3),

                    Textarea::make('risks_and_opportunities')
                        ->label('Risks and Opportunities')
                        ->rows(3),

                    Textarea::make('interaction_with')
                        ->label('Interaction with Other Processes')
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
                TextColumn::make('process_code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Process')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('process_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'strategic' => 'Strategic',
                            'operational' => 'Operational',
                            'support' => 'Support',
                            'monitoring' => 'Monitoring and Evaluation',
                            default => ucfirst($state ?? ''),
                        }
                    ),

                TextColumn::make('owner_name')
                    ->label('Process Owner')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'draft' => 'Draft',
                            'active' => 'Active',
                            'under_review' => 'Under Review',
                            'inactive' => 'Inactive',
                            default => ucfirst($state ?? ''),
                        }
                    )
                    ->color(
                        fn (?string $state): string => match ($state) {
                            'draft' => 'gray',
                            'active' => 'success',
                            'under_review' => 'warning',
                            'inactive' => 'danger',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function canViewAny(): bool
    {
        return self::userHasPermission('processes.view');
    }

    public static function canCreate(): bool
    {
        return self::userHasPermission('processes.create');
    }

    public static function canEdit($record): bool
    {
        return self::userHasPermission('processes.update');
    }

    public static function canDelete($record): bool
    {
        return self::userHasPermission('processes.delete');
    }

    private static function userHasPermission(string $permission): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        $userId = $user->getAuthIdentifier();

        // Super Admin has full access to this resource.
        $isSuperAdmin = DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where('model_has_roles.model_id', $userId)
            ->where('model_has_roles.model_type', User::class)
            ->where('roles.name', 'Super Admin')
            ->where('roles.guard_name', 'web')
            ->exists();

        if ($isSuperAdmin) {
            return true;
        }

        // Check permissions assigned directly to the user.
        $hasDirectPermission = DB::table('model_has_permissions')
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'model_has_permissions.permission_id'
            )
            ->where('model_has_permissions.model_id', $userId)
            ->where('model_has_permissions.model_type', User::class)
            ->where('permissions.name', $permission)
            ->where('permissions.guard_name', 'web')
            ->exists();

        if ($hasDirectPermission) {
            return true;
        }

        // Check permissions assigned through roles.
        return DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->join(
                'role_has_permissions',
                'role_has_permissions.role_id',
                '=',
                'roles.id'
            )
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'role_has_permissions.permission_id'
            )
            ->where('model_has_roles.model_id', $userId)
            ->where('model_has_roles.model_type', User::class)
            ->where('permissions.name', $permission)
            ->where('permissions.guard_name', 'web')
            ->exists();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQmsProcesses::route('/'),
            'create' => CreateQmsProcess::route('/create'),
            'edit' => EditQmsProcess::route('/{record}/edit'),
        ];
    }
}

