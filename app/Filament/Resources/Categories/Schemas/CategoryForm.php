<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Ảnh đại diện lĩnh vực')
                    ->helperText('Ảnh riêng cho lĩnh vực này (hiển thị ở trang chủ và trang danh mục). Nếu chưa upload, hệ thống sẽ tạm dùng ảnh của một sản phẩm trong nhóm. Chấp nhận JPG/PNG/WEBP tối đa 15MB — không bắt buộc crop, ảnh tỉ lệ nào cũng lên được.')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('categories')
                    ->maxSize(15360)
                    ->columnSpanFull(),

                Tabs::make('CategoryTranslations')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('🇻🇳 Tiếng Việt')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Tên danh mục')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Textarea::make('description')
                                    ->label('Mô tả')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('🇬🇧 English')
                            ->badge(fn ($record) => $record && blank($record->name_en) ? '!' : null)
                            ->badgeColor('warning')
                            ->schema([
                                TextInput::make('name_en')
                                    ->label('Category name (EN)'),
                                Textarea::make('description_en')
                                    ->label('Description (EN)')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                TextInput::make('group_code')
                    ->label('Mã nhóm (theo danh mục trang thiết bị, VD: A, B, C...)')
                    ->maxLength(2),
                Select::make('parent_id')
                    ->label('Danh mục cha (để trống nếu là danh mục cấp 1)')
                    ->options(fn () => Category::query()->whereNull('parent_id')->pluck('name', 'id'))
                    ->searchable(),
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
