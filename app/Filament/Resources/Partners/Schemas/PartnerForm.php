<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Tên hãng / đối tác')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('logo_path')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('partners/logos')
                    ->maxSize(2048)
                    ->columnSpanFull(),
                TextInput::make('country')
                    ->label('Quốc gia (VI)'),
                TextInput::make('country_en')
                    ->label('Country (EN)'),
                TextInput::make('specialty')
                    ->label('Chuyên cung cấp (VI)'),
                TextInput::make('specialty_en')
                    ->label('Specialty (EN)'),
                TextInput::make('website_url')
                    ->label('Website')
                    ->url()
                    ->columnSpanFull(),
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
