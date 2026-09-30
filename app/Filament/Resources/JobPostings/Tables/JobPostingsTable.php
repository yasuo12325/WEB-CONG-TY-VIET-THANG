<?php

namespace App\Filament\Resources\JobPostings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class JobPostingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image_path')
                    ->label('Ảnh')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->label('Tên vị trí')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Địa điểm')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => $state === 'published' ? 'Đã đăng' : 'Bản nháp')
                    ->color(fn (string $state) => $state === 'published' ? 'success' : 'gray'),
                TextColumn::make('deadline')
                    ->label('Hạn nộp hồ sơ')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->label('Ngày đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Người đăng')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Bản nháp',
                        'published' => 'Đã đăng',
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
