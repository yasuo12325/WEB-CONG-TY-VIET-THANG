<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Ảnh')
                    ->disk('public')
                    ->square()
                    ->size(48),
                TextColumn::make('group_code')
                    ->label('Nhóm')
                    ->badge(),
                TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Danh mục cha')
                    ->searchable()
                    ->placeholder('— Cấp 1 —'),
                TextColumn::make('products_count')
                    ->label('Số sản phẩm')
                    ->counts('products'),
                IconColumn::make('name_en')
                    ->label('EN')
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->name_en))
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-triangle')
                    ->trueColor('success')
                    ->falseColor('warning'),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),
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
            ])
            ->defaultSort('sort_order');
    }
}
