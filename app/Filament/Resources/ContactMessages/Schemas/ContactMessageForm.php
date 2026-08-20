<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Họ tên')
                    ->disabled(),
                TextInput::make('email')
                    ->label('Email')
                    ->disabled(),
                TextInput::make('phone')
                    ->label('Điện thoại')
                    ->disabled(),
                TextInput::make('subject')
                    ->label('Tiêu đề')
                    ->disabled()
                    ->columnSpanFull(),
                Textarea::make('message')
                    ->label('Nội dung')
                    ->disabled()
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'new' => 'Mới',
                        'read' => 'Đã đọc',
                        'archived' => 'Lưu trữ',
                    ])
                    ->required()
                    ->native(false),
            ])
            ->columns(2);
    }
}
