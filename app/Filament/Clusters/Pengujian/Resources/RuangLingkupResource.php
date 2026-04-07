<?php

namespace App\Filament\Clusters\Pengujian\Resources;

use App\Filament\Clusters\Pengujian\PengujianCluster;
use App\Filament\Clusters\Pengujian\Resources\RuangLingkupResource\Pages;
use App\Models\RuangLingkup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RuangLingkupResource extends Resource
{
    protected static ?string $model = RuangLingkup::class;

    protected static ?string $cluster = PengujianCluster::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Square3Stack3d;

    protected static ?string $navigationLabel = 'Ruang Lingkup';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('komoditi')
                ->required(),
            Textarea::make('ruang_lingkup')
                ->rows(5)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('komoditi')
                    ->searchable(),
                TextColumn::make('ruang_lingkup')
                    ->limit(50)
                    ->searchable(),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRuangLingkups::route('/'),
            'create' => Pages\CreateRuangLingkup::route('/create'),
            'edit' => Pages\EditRuangLingkup::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
    }
}
