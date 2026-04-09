<?php

namespace App\Filament\Clusters\Lsih\Resources;

use App\Filament\Clusters\Lsih\LsihCluster;
use App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages\CreateLsihAlur;
use App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages\EditLsihAlur;
use App\Filament\Clusters\Lsih\Resources\LsihAlurResource\Pages\ListLsihAlurs;
use App\Models\LsihAlur;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class LsihAlurResource extends Resource
{
    protected static ?string $cluster = LsihCluster::class;

    protected static ?string $model = LsihAlur::class;

    protected static ?string $navigationLabel = 'Alur';

    protected static ?string $pluralLabel = 'Alur';

    protected static ?string $modelLabel = 'Alur';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Alur LSIH')
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('lsih/alur')
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
            'index' => ListLsihAlurs::route('/'),
            'create' => CreateLsihAlur::route('/create'),
            'edit' => EditLsihAlur::route('/{record}/edit'),
        ];
    }
}
