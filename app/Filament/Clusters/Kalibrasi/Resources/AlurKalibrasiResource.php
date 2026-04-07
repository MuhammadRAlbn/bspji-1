<?php

namespace App\Filament\Clusters\Kalibrasi\Resources;

use App\Filament\Clusters\Kalibrasi\KalibrasiCluster;
use App\Models\AlurKalibrasi;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlurKalibrasiResource extends Resource
{
    protected static ?string $model = AlurKalibrasi::class;

    protected static ?string $cluster = KalibrasiCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedPresentationChartLine;

    protected static ?string $navigationLabel = 'Alur Kalibrasi';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('alur-kalibrasi')
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
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => AlurKalibrasiResource\Pages\ListAlurKalibrasis::route('/'),
            'create' => AlurKalibrasiResource\Pages\CreateAlurKalibrasi::route('/create'),
            'edit' => AlurKalibrasiResource\Pages\EditAlurKalibrasi::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return AlurKalibrasi::count() === 0;
    }
}
