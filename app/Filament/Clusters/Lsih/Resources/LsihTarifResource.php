<?php

namespace App\Filament\Clusters\Lsih\Resources;

use App\Filament\Clusters\Lsih\LsihCluster;
use App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages\CreateLsihTarif;
use App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages\EditLsihTarif;
use App\Filament\Clusters\Lsih\Resources\LsihTarifResource\Pages\ListLsihTarifs;
use App\Models\LsihTarif;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class LsihTarifResource extends Resource
{
    protected static ?string $cluster = LsihCluster::class;

    protected static ?string $model = LsihTarif::class;

    protected static ?string $navigationLabel = 'Tarif';

    protected static ?string $pluralLabel = 'Tarif';

    protected static ?string $modelLabel = 'Tarif';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tarif LSIH')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('lsih/tarif')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ])
            ->paginated(false);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLsihTarifs::route('/'),
            'create' => CreateLsihTarif::route('/create'),
            'edit' => EditLsihTarif::route('/{record}/edit'),
        ];
    }
}
