<?php

namespace App\Filament\Clusters\Pengujian\Resources;

use App\Filament\Clusters\Pengujian\PengujianCluster;
use App\Filament\Clusters\Pengujian\Resources\AlurPengujianResource\Pages;
use App\Models\AlurPengujian;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class AlurPengujianResource extends Resource
{
    protected static ?string $model = AlurPengujian::class;

    protected static ?string $cluster = PengujianCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ArrowPath;

    protected static ?string $navigationLabel = 'Alur Pengujian';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('alur_pengujian')
                ->visibility('public')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlurPengujians::route('/'),
            'create' => Pages\CreateAlurPengujian::route('/create'),
            'edit' => Pages\EditAlurPengujian::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return AlurPengujian::count() < 1;
    }
}
