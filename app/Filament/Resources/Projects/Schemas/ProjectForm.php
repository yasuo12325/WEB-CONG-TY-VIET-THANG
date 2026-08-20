<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Tên dự án')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
                TextInput::make('client_name')
                    ->label('Khách hàng / Chủ đầu tư (để trống nếu bảo mật)'),
                TextInput::make('completed_year')
                    ->label('Năm hoàn thành')
                    ->numeric(),
                Textarea::make('summary')
                    ->label('Tóm tắt')
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->label('Nội dung chi tiết')
                    ->columnSpanFull(),
                FileUpload::make('cover_image_path')
                    ->label('Ảnh bìa')
                    ->image()
                    ->disk('public')
                    ->directory('projects')
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
            ])
            ->columns(2);
    }
}
