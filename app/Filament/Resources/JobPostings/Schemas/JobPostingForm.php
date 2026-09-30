<?php

namespace App\Filament\Resources\JobPostings\Schemas;

use Filament\Forms\Components\DatePicker;
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

class JobPostingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('JobPostingTranslations')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('🇻🇳 Tiếng Việt')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Tên vị trí')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state)))
                                    ->columnSpanFull(),
                                TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                TextInput::make('location')
                                    ->label('Địa điểm làm việc')
                                    ->placeholder('VD: Hà Nội')
                                    ->columnSpanFull(),
                                Textarea::make('excerpt')
                                    ->label('Tóm tắt')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                RichEditor::make('body')
                                    ->label('Nội dung (Mô tả công việc, Yêu cầu, Quyền lợi...)')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('jobs')
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('🇬🇧 English')
                            ->badge(fn ($record) => $record && blank($record->title_en) ? '!' : null)
                            ->badgeColor('warning')
                            ->schema([
                                TextInput::make('title_en')
                                    ->label('Position title (EN)')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, $set) => $set('slug_en', $state ? Str::slug($state) : null))
                                    ->columnSpanFull(),
                                TextInput::make('slug_en')
                                    ->label('Slug (EN URL)')
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),
                                TextInput::make('location_en')
                                    ->label('Location (EN)')
                                    ->placeholder('E.g. Hanoi')
                                    ->columnSpanFull(),
                                Textarea::make('excerpt_en')
                                    ->label('Excerpt (EN)')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                RichEditor::make('body_en')
                                    ->label('Body (EN)')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('jobs')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                FileUpload::make('cover_image_path')
                    ->label('Ảnh minh họa (không bắt buộc)')
                    ->image()
                    ->disk('public')
                    ->directory('jobs')
                    ->maxSize(4096),
                DatePicker::make('deadline')
                    ->label('Hạn nộp hồ sơ')
                    ->native(false),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'draft' => 'Bản nháp',
                        'published' => 'Đã đăng',
                    ])
                    ->default('draft')
                    ->required()
                    ->native(false),
                DateTimePicker::make('published_at')
                    ->label('Ngày đăng')
                    ->native(false),
                Select::make('author_id')
                    ->label('Người đăng')
                    ->relationship('author', 'name')
                    ->default(fn () => auth()->id()),
            ])
            ->columns(2);
    }
}
