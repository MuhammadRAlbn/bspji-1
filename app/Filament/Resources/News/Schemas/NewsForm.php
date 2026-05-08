<?php

namespace App\Filament\Resources\News\Schemas;

use App\Models\News;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Gunakan huruf kecil dan tanda hubung, contoh: kegiatan-standardisasi-2026.')
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->label('Gambar Sampul')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('berita')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->columnSpanFull(),
                Textarea::make('excerpt')
                    ->label('Ringkasan')
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
                RichEditor::make('body')
                    ->label('Isi Berita')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Status')
                    ->options(News::STATUS_OPTIONS)
                    ->required()
                    ->default(News::STATUS_DRAFT)
                    ->native(false),
                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->seconds(false)
                    ->native(false)
                    ->helperText('Jika status Published dan tanggal kosong, sistem mengisi waktu saat disimpan.'),
            ]);
    }
}
