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
use Filament\Schemas\Components\Text;
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
                                    ->required()
                                    ->columnSpan(1),
                                TextInput::make('model_number')
                                    ->label('Model / Mã sản phẩm')
                                    ->helperText('Không dịch — giữ nguyên ở cả 2 ngôn ngữ.')
                                    ->columnSpan(1),

                                Tabs::make('ProductTranslations')
                                    ->columnSpanFull()
                                    ->tabs([
                                        Tab::make('🇻🇳 Tiếng Việt')
                                            ->schema([
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
                                                TextInput::make('short_description')
                                                    ->label('Mô tả ngắn')
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                                RichEditor::make('description')
                                                    ->label('Mô tả chi tiết')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2),
                                        Tab::make('🇬🇧 English')
                                            ->badge(fn ($record) => $record && blank($record->name_en) ? '!' : null)
                                            ->badgeColor('warning')
                                            ->schema([
                                                TextInput::make('name_en')
                                                    ->label('Product name (EN)')
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, $set) => $set('slug_en', $state ? Str::slug($state) : null))
                                                    ->columnSpan(1),
                                                TextInput::make('slug_en')
                                                    ->label('Slug (EN URL)')
                                                    ->unique(ignoreRecord: true)
                                                    ->helperText('Để trống sẽ tự tạo từ Product name (EN).')
                                                    ->columnSpan(1),
                                                TextInput::make('short_description_en')
                                                    ->label('Short description (EN)')
                                                    ->maxLength(255)
                                                    ->columnSpanFull(),
                                                RichEditor::make('description_en')
                                                    ->label('Full description (EN)')
                                                    ->columnSpanFull(),
                                                Text::make('Chưa dịch sẽ tự động hiển thị bản tiếng Việt trên website (fallback) — không để trống ngoài ý muốn khi đã có nội dung EN.')
                                                    ->color('gray')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2),
                                    ]),
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
                                    ->label('Catalogue / Brochure PDF (tối đa 10 file — VI và EN riêng biệt)')
                                    ->relationship('documents')
                                    ->schema([
                                        Select::make('locale')
                                            ->label('Ngôn ngữ tài liệu')
                                            ->options(['vi' => '🇻🇳 Tiếng Việt', 'en' => '🇬🇧 English'])
                                            ->default('vi')
                                            ->required()
                                            ->native(false),
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
                                            ->placeholder('VD: Catalogue / Datasheet')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->reorderable()
                                    ->orderColumn('sort_order')
                                    ->maxItems(10)
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
                                            ->label('Nhóm (VI)')
                                            ->placeholder('VD: Tổng quan, Hiệu năng...'),
                                        TextInput::make('spec_key')
                                            ->label('Thông số (VI)')
                                            ->required(),
                                        TextInput::make('spec_value')
                                            ->label('Giá trị (số/đơn vị — dùng chung 2 ngôn ngữ)')
                                            ->required()
                                            ->helperText('Số liệu, đơn vị, model... không đổi giữa VI/EN.'),
                                        TextInput::make('spec_group_en')
                                            ->label('Group (EN)'),
                                        TextInput::make('spec_key_en')
                                            ->label('Spec label (EN)'),
                                        TextInput::make('spec_value_en')
                                            ->label('Value override (EN, hiếm khi cần)')
                                            ->helperText('Chỉ điền nếu giá trị là văn bản mô tả cần dịch — để trống nếu là số/đơn vị.'),
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
                                    ->label('Sản phẩm nổi bật')
                                    ->helperText('Hiện ở khối "Sản phẩm nổi bật" trên trang chủ (tối đa 8 sản phẩm — có thể bật/tắt nhanh ngay trong danh sách sản phẩm).'),
                                TextInput::make('sort_order')
                                    ->label('Thứ tự hiển thị')
                                    ->helperText('Số nhỏ hơn hiển thị trước — dùng cho cả danh sách trong danh mục lẫn khối "Sản phẩm nổi bật".')
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
