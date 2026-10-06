<?php

namespace App\Filament\Resources\QmsScopes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QmsScopesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                    ->label('Scope')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'draft' => 'Draft',
                            'under_review' => 'Under Review',
                            'approved' => 'Approved',
                            'superseded' => 'Superseded',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'draft' => 'gray',
                            'under_review' => 'warning',
                            'approved' => 'success',
                            'superseded' => 'danger',
                            default => 'gray',
                        }
                    ),

                TextColumn::make('effective_date')
                    ->label('Effective Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('review_date')
                    ->label('Review Date')
                    ->date()
                    ->sortable(),

                TextColumn::make('preparedBy.name')
                    ->label('Prepared By')
                    ->searchable(),

                TextColumn::make('approvedBy.name')
                    ->label('Approved By')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
                //
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
}
