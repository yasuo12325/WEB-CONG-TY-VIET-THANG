<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('ProjectTranslations')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('🇻🇳 Tiếng Việt')
                            ->schema([
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
                                Textarea::make('summary')
                                    ->label('Tóm tắt')
                                    ->columnSpanFull(),
                                RichEditor::make('body')
                                    ->label('Nội dung chi tiết')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('🇬🇧 English')
                            ->badge(fn ($record) => $record && blank($record->title_en) ? '!' : null)
                            ->badgeColor('warning')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Project name (EN)')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug_en', $state ? Str::slug($state) : null))
                                    ->columnSpanFull(),
                                TextInput::make('slug_en')
                                    ->label('Slug (EN URL)')
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                Textarea::make('summary_en')
                                    ->label('Summary (EN)')
                                    ->columnSpanFull(),
                                RichEditor::make('body_en')
                                    ->label('Full description (EN)')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                TextInput::make('client_name')
                    ->label('Khách hàng / Chủ đầu tư (để trống nếu bảo mật)')
                    ->helperText('Tên riêng — không dịch.'),
                TextInput::make('completed_year')
                    ->label('Năm hoàn thành')
                    ->numeric(),
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
