<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên danh mục')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('group_code')
                    ->label('Mã nhóm (theo danh mục trang thiết bị, VD: A, B, C...)')
                    ->maxLength(2),
                Select::make('parent_id')
                    ->label('Danh mục cha (để trống nếu là danh mục cấp 1)')
                    ->options(fn () => Category::query()->whereNull('parent_id')->pluck('name', 'id'))
                    ->searchable(),
                Textarea::make('description')
                    ->label('Mô tả')
                    ->columnSpanFull(),
                TextInput::make('icon')
                    ->label('Icon (tên icon Heroicon, VD: shield-check)'),
                TextInput::make('sort_order')
                    ->label('Thứ tự hiển thị')
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->label('Hiển thị')
                    ->default(true),
            ])
            ->columns(2);
    }
}
