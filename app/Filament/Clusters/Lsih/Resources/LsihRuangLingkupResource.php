<?php

namespace App\Filament\Clusters\Lsih\Resources;

use App\Filament\Clusters\Lsih\LsihCluster;
use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages\CreateLsihRuangLingkup;
use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages\EditLsihRuangLingkup;
use App\Filament\Clusters\Lsih\Resources\LsihRuangLingkupResource\Pages\ListLsihRuangLingkups;
use App\Models\LsihRuangLingkup;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class LsihRuangLingkupResource extends Resource
{
    protected static ?string $cluster = LsihCluster::class;

    protected static ?string $model = LsihRuangLingkup::class;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    protected static ?string $pluralLabel = 'Ruang Lingkup';

    protected static ?string $modelLabel = 'Ruang Lingkup';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ruang Lingkup LSIH')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('lsih/ruang-lingkup')
                            ->disk('public')
                            ->visibility('public')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public'),
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
            'index' => ListLsihRuangLingkups::route('/'),
            'create' => CreateLsihRuangLingkup::route('/create'),
            'edit' => EditLsihRuangLingkup::route('/{record}/edit'),
        ];
    }
}
