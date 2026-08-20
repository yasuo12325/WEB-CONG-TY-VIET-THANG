<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Thông tin chung')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Danh mục')
                                    ->relationship('category', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('name')
                                    ->label('Tên sản phẩm')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                    ->columnSpan(1),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpan(1),
                                TextInput::make('model_number')
                                    ->label('Model / Mã sản phẩm'),
                                TextInput::make('short_description')
                                    ->label('Mô tả ngắn')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                RichEditor::make('description')
                                    ->label('Mô tả chi tiết')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make('Hình ảnh')
                            ->schema([
                                Repeater::make('images')
                                    ->label('Ảnh sản phẩm (tối đa 10 ảnh)')
                                    ->relationship('images')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('Ảnh')
                                            ->image()
                                            ->disk('public')
                                            ->directory('products/images')
                                            ->maxSize(4096)
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->required()
                                            ->columnSpanFull(),
                                        TextInput::make('alt_text')
                                            ->label('Mô tả ảnh (alt text)'),
                                        Toggle::make('is_primary')
                                            ->label('Ảnh đại diện'),
                                    ])
                                    ->columns(2)
                                    ->reorderable()
                                    ->orderColumn('sort_order')
                                    ->maxItems(10)
                                    ->addActionLabel('Thêm ảnh')
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Tài liệu (PDF)')
                            ->schema([
                                Repeater::make('documents')
                                    ->label('Catalogue / Brochure PDF (tối đa 5 file)')
                                    ->relationship('documents')
                                    ->schema([
                                        FileUpload::make('path')
                                            ->label('File PDF')
                                            ->disk('public')
                                            ->directory('products/documents')
                                            ->maxSize(20480)
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->required()
                                            ->columnSpanFull()
                                            ->afterStateUpdated(function ($state, $set) {
                                                if ($state) {
                                                    $set('original_filename', $state->getClientOriginalName());
                                                    $set('file_size', $state->getSize());
                                                    $set('mime_type', $state->getMimeType());
                                                }
                                            }),
                                        TextInput::make('label')
                                            ->label('Nhãn tài liệu')
                                            ->placeholder('VD: Catalogue Tiếng Việt')
                                            ->columnSpanFull(),
                                    ])
                                    ->reorderable()
                                    ->orderColumn('sort_order')
                                    ->maxItems(5)
                                    ->addActionLabel('Thêm tài liệu')
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Thông số kỹ thuật')
                            ->schema([
                                Repeater::make('specs')
                                    ->label('Thông số')
                                    ->relationship('specs')
                                    ->schema([
                                        TextInput::make('spec_group')
                                            ->label('Nhóm')
                                            ->placeholder('VD: Tổng quan, Hiệu năng...'),
                                        TextInput::make('spec_key')
                                            ->label('Thông số')
                                            ->required(),
                                        TextInput::make('spec_value')
                                            ->label('Giá trị')
                                            ->required(),
                                    ])
                                    ->columns(3)
                                    ->reorderable()
                                    ->orderColumn('sort_order')
                                    ->addActionLabel('Thêm thông số')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Xuất bản & SEO')
                            ->schema([
                                Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'draft' => 'Bản nháp',
                                        'published' => 'Đã xuất bản',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->native(false),
                                Toggle::make('is_featured')
                                    ->label('Sản phẩm nổi bật'),
                                TextInput::make('sort_order')
                                    ->label('Thứ tự hiển thị')
                                    ->numeric()
                                    ->default(0),
                                DateTimePicker::make('published_at')
                                    ->label('Ngày xuất bản')
                                    ->native(false),
                                TextInput::make('meta_title')
                                    ->label('Meta title (SEO)')
                                    ->columnSpanFull(),
                                Textarea::make('meta_description')
                                    ->label('Meta description (SEO)')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
