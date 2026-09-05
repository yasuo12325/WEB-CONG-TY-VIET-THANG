<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Quản trị';

    protected static ?string $navigationLabel = 'Thông tin công ty';

    protected static ?string $title = 'Thông tin công ty';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super-admin', 'editor']) ?? false;
    }

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::get('company_name'),
            'company_name_intl' => Setting::get('company_name_intl'),
            'company_short_name' => Setting::get('company_short_name'),
            'founded_year' => Setting::get('founded_year'),
            'charter_capital' => Setting::get('charter_capital'),
            'employee_count' => Setting::get('employee_count'),
            'partner_count' => Setting::get('partner_count'),
            'ceo_name' => Setting::get('ceo_name'),
            'headquarters_address' => Setting::get('headquarters_address'),
            'office_address' => Setting::get('office_address'),
            'phone' => Setting::get('phone'),
            'fax' => Setting::get('fax'),
            'email' => Setting::get('email'),
            'website' => Setting::get('website'),
            'logo_path' => Setting::get('logo_path'),
            'hero_headline' => Setting::get('hero_headline'),
            'hero_headline_en' => Setting::get('hero_headline_en'),
            'hero_subheadline' => Setting::get('hero_subheadline'),
            'hero_subheadline_en' => Setting::get('hero_subheadline_en'),
            'about_summary' => Setting::get('about_summary'),
            'about_summary_en' => Setting::get('about_summary_en'),
            'about_image_path' => Setting::get('about_image_path'),
            'about_content' => Setting::get('about_content'),
            'about_content_en' => Setting::get('about_content_en'),
            'technology_content' => Setting::get('technology_content'),
            'technology_content_en' => Setting::get('technology_content_en'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Thương hiệu')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->columnSpanFull(),
                        TextInput::make('company_short_name')->label('Tên viết tắt'),
                        TextInput::make('founded_year')->label('Năm thành lập'),
                        TextInput::make('employee_count')->label('Số nhân sự'),
                        TextInput::make('partner_count')->label('Số đối tác'),
                    ]),
                Section::make('Thông tin pháp lý')
                    ->columns(2)
                    ->schema([
                        TextInput::make('company_name')->label('Tên công ty (tiếng Việt)')->columnSpanFull(),
                        TextInput::make('company_name_intl')->label('Tên giao dịch quốc tế')->columnSpanFull(),
                        TextInput::make('charter_capital')->label('Vốn điều lệ'),
                        TextInput::make('ceo_name')->label('Tổng Giám đốc'),
                    ]),
                Section::make('Thông tin liên hệ')
                    ->columns(2)
                    ->schema([
                        Textarea::make('headquarters_address')->label('Trụ sở chính')->columnSpanFull(),
                        Textarea::make('office_address')->label('Văn phòng giao dịch')->columnSpanFull(),
                        TextInput::make('phone')->label('Điện thoại'),
                        TextInput::make('fax')->label('Fax'),
                        TextInput::make('email')->label('Email')->email(),
                        TextInput::make('website')->label('Website')->url(),
                    ]),
                Section::make('Trang chủ — 🇻🇳 Tiếng Việt')
                    ->columns(1)
                    ->schema([
                        TextInput::make('hero_headline')->label('Tiêu đề banner'),
                        Textarea::make('hero_subheadline')->label('Mô tả banner'),
                        Textarea::make('about_summary')->label('Tóm tắt giới thiệu (hiển thị ở trang chủ)'),
                    ]),
                Section::make('Trang chủ — 🇬🇧 English')
                    ->columns(1)
                    ->schema([
                        TextInput::make('hero_headline_en')->label('Hero headline (EN)'),
                        Textarea::make('hero_subheadline_en')->label('Hero subheadline (EN)'),
                        Textarea::make('about_summary_en')->label('About summary (EN)'),
                    ]),
                Section::make('Trang "Giới thiệu công ty"')
                    ->description('Ảnh và nội dung hiển thị tại trang /gioi-thieu (phía trên phần địa chỉ trụ sở).')
                    ->columns(1)
                    ->schema([
                        FileUpload::make('about_image_path')
                            ->label('Ảnh giới thiệu công ty')
                            ->helperText('Hiển thị ở đầu trang "Giới thiệu công ty" (ảnh trụ sở, đội ngũ hoặc sản phẩm tiêu biểu). Dùng chung cho cả 2 ngôn ngữ.')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('settings/about')
                            ->maxSize(15360),
                        Textarea::make('about_content')
                            ->label('Nội dung giới thiệu — 🇻🇳 Tiếng Việt')
                            ->helperText('Dán toàn bộ đoạn giới thiệu công ty. Xuống dòng sẽ tự động xuống dòng trên trang.')
                            ->rows(14),
                        Textarea::make('about_content_en')
                            ->label('Nội dung giới thiệu — 🇬🇧 English')
                            ->rows(14),
                    ]),
                Section::make('Trang "Công nghệ"')
                    ->description('Nội dung hiển thị tại trang /cong-nghe. Có thể vừa gõ chữ vừa chèn ảnh ngay trong cùng một ô, giống soạn thảo văn bản thông thường.')
                    ->columns(1)
                    ->schema([
                        RichEditor::make('technology_content')
                            ->label('Nội dung — 🇻🇳 Tiếng Việt')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('settings/technology')
                            ->columnSpanFull(),
                        RichEditor::make('technology_content_en')
                            ->label('Nội dung — 🇬🇧 English')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('settings/technology')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Đã lưu thông tin công ty')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu thay đổi')
                ->action('save'),
        ];
    }
}
