<?php

namespace App\Filament\Clusters\Kalibrasi\Resources;

use App\Filament\Clusters\Kalibrasi\KalibrasiCluster;
use App\Filament\Clusters\Kalibrasi\Resources\SertifikasiKalibrasiResource\Pages;
use App\Models\SertifikasiKalibrasi;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SertifikasiKalibrasiResource extends Resource
{
    protected static ?string $model = SertifikasiKalibrasi::class;

    protected static ?string $cluster = KalibrasiCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Sertifikasi';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('sertifikasi-kalibrasi')
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSertifikasiKalibrasis::route('/'),
            'create' => Pages\CreateSertifikasiKalibrasi::route('/create'),
            'edit' => Pages\EditSertifikasiKalibrasi::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return SertifikasiKalibrasi::count() === 0;
    }
}
