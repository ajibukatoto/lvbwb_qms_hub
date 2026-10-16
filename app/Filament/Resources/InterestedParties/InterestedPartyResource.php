<?php

namespace App\Filament\Resources\InterestedParties;

use App\Filament\Resources\InterestedParties\Pages\CreateInterestedParty;
use App\Filament\Resources\InterestedParties\Pages\EditInterestedParty;
use App\Filament\Resources\InterestedParties\Pages\ListInterestedParties;
use App\Models\InterestedParty;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UnitEnum;

class InterestedPartyResource extends Resource
{
    protected static ?string $model = InterestedParty::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'QMS';

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Interested Parties';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Interested Party Information')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),

                    Select::make('party_type')
                        ->label('Party Type')
                        ->options([
                            'internal' => 'Internal',
                            'external' => 'External',
                        ])
                        ->required()
                        ->default('external'),

                    Textarea::make('needs_and_expectations')
                        ->label('Needs and Expectations')
                        ->required()
                        ->rows(4)
                        ->columnSpanFull(),

                    Textarea::make('qms_relevance')
                        ->label('Relevance to QMS')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('monitoring_method')
                        ->label('Monitoring / Review Method')
                        ->rows(3)
                        ->columnSpanFull(),

                    TextInput::make('responsible_person')
                        ->label('Responsible Person')
                        ->maxLength(255),

                    DatePicker::make('review_date')
                        ->label('Next Review Date')
                        ->native(false),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('party_type')
                    ->label('Type')
                    ->badge()
                    ->color(
                        fn (string $state): string =>
                            $state === 'internal' ? 'info' : 'success'
                    ),

                TextColumn::make('responsible_person')
                    ->label('Responsible Person')
                    ->searchable(),

                TextColumn::make('review_date')
                    ->date()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                TextColumn::make('created_at')
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
        return self::userHasPermission('qms-context.view');
    }

    public static function canCreate(): bool
    {
        return self::userHasPermission('qms-context.create');
    }

    public static function canEdit($record): bool
    {
        return self::userHasPermission('qms-context.update');
    }

    public static function canDelete($record): bool
    {
        return self::userHasPermission('qms-context.delete');
    }

    private static function userHasPermission(string $permission): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        // Super Admin is allowed to manage all QMS resources.
        $isSuperAdmin = DB::table('model_has_roles')
            ->join(
                'roles',
                'roles.id',
                '=',
                'model_has_roles.role_id'
            )
            ->where('model_has_roles.model_id', $user->getAuthIdentifier())
            ->where('model_has_roles.model_type', User::class)
            ->where('roles.name', 'Super Admin')
            ->exists();

        if ($isSuperAdmin) {
            return true;
        }

        // Check the user's directly assigned permissions.
        $hasDirectPermission = DB::table('model_has_permissions')
            ->join(
                'permissions',
                'permissions.id',
                '=',
                'model_has_permissions.permission_id'
            )
            ->where('model_has_permissions.model_id', $user->getAuthIdentifier())
            ->where('model_has_permissions.model_type', User::class)
            ->where('permissions.name', $permission)
            ->where('permissions.guard_name', 'web')
            ->exists();

        if ($hasDirectPermission) {
            return true;
        }

        // Check permissions inherited through assigned roles.
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
            ->where('model_has_roles.model_id', $user->getAuthIdentifier())
            ->where('model_has_roles.model_type', User::class)
            ->where('permissions.name', $permission)
            ->where('permissions.guard_name', 'web')
            ->exists();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInterestedParties::route('/'),
            'create' => CreateInterestedParty::route('/create'),
            'edit' => EditInterestedParty::route('/{record}/edit'),
        ];
    }
}
