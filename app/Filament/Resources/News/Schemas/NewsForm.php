<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('NewsTranslations')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('🇻🇳 Tiếng Việt')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Tiêu đề')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                Textarea::make('excerpt')
                                    ->label('Tóm tắt')
                                    ->columnSpanFull(),
                                RichEditor::make('body')
                                    ->label('Nội dung')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('🇬🇧 English')
                            ->badge(fn ($record) => $record && blank($record->title_en) ? '!' : null)
                            ->badgeColor('warning')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Title (EN)')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug_en', $state ? Str::slug($state) : null))
                                    ->columnSpanFull(),
                                TextInput::make('slug_en')
                                    ->label('Slug (EN URL)')
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                Textarea::make('excerpt_en')
                                    ->label('Excerpt (EN)')
                                    ->columnSpanFull(),
                                RichEditor::make('body_en')
                                    ->label('Body (EN)')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                FileUpload::make('cover_image_path')
                    ->label('Ảnh bìa')
                    ->image()
                    ->disk('public')
                    ->directory('news')
                    ->maxSize(4096),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Bản nháp',
                        'published' => 'Đã xuất bản',
                    ])
                    ->default('draft')
                    ->required()
                    ->native(false),
                DateTimePicker::make('published_at')
                    ->label('Ngày xuất bản')
                    ->native(false),
                Select::make('author_id')
                    ->label('Tác giả')
                    ->relationship('author', 'name')
                    ->default(fn () => auth()->id()),
            ])
            ->columns(2);
    }
}
