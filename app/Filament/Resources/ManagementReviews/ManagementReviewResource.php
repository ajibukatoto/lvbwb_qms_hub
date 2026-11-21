<?php

namespace App\Filament\Resources\ManagementReviews;

use App\Filament\Resources\ManagementReviews\Pages\CreateManagementReview;
use App\Filament\Resources\ManagementReviews\Pages\EditManagementReview;
use App\Filament\Resources\ManagementReviews\Pages\ListManagementReviews;
use App\Filament\Resources\ManagementReviews\Schemas\ManagementReviewForm;
use App\Filament\Resources\ManagementReviews\Tables\ManagementReviewsTable;
use App\Models\ManagementReview;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManagementReviewResource extends Resource
{
    protected static ?string $model = ManagementReview::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ManagementReviewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManagementReviewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListManagementReviews::route('/'),
            'create' => CreateManagementReview::route('/create'),
            'edit' => EditManagementReview::route('/{record}/edit'),
        ];
    }
}
