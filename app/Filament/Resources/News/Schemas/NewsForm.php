<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
