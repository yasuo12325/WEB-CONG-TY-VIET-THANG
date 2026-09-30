<?php

namespace App\Filament\Resources\Partners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_path')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Tên hãng')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country')
                    ->label('Quốc gia')
                    ->searchable(),
                TextColumn::make('specialty')
                    ->label('Chuyên cung cấp')
                    ->searchable(),
                TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Hiển thị')
                    ->boolean(),
                ToggleColumn::make('is_featured')
                    ->label('Tiêu biểu')
                    ->tooltip('Bật để hiện ở khối "Đối tác tiêu biểu" trên trang chủ với nhãn "Đại diện độc quyền".'),
            ])
            ->filters([
                TernaryFilter::make('is_featured')
                    ->label('Tiêu biểu')
                    ->placeholder('Tất cả đối tác')
                    ->trueLabel('Chỉ đối tác tiêu biểu')
                    ->falseLabel('Chỉ đối tác thường'),
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
