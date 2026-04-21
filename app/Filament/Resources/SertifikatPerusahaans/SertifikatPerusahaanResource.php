<?php

namespace App\Filament\Resources\SertifikatPerusahaans;

use App\Filament\Resources\SertifikatPerusahaans\Pages\CreateSertifikatPerusahaan;
use App\Filament\Resources\SertifikatPerusahaans\Pages\EditSertifikatPerusahaan;
use App\Filament\Resources\SertifikatPerusahaans\Pages\ListSertifikatPerusahaans;
use App\Filament\Resources\SertifikatPerusahaans\Schemas\SertifikatPerusahaanForm;
use App\Filament\Resources\SertifikatPerusahaans\Tables\SertifikatPerusahaansTable;
use App\Models\SertifikatPerusahaan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SertifikatPerusahaanResource extends Resource
{
    protected static ?string $model = SertifikatPerusahaan::class;

    protected static ?string $slug = 'sertifikat';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static \UnitEnum|string|null $navigationGroup = 'Landing Page';

    protected static ?string $modelLabel = 'Sertifikat';

    protected static ?string $pluralModelLabel = 'Sertifikat';

    protected static ?string $navigationLabel = 'Sertifikat';

    public static function form(Schema $schema): Schema
    {
        return SertifikatPerusahaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SertifikatPerusahaansTable::configure($table);
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
            'index' => ListSertifikatPerusahaans::route('/'),
            'create' => CreateSertifikatPerusahaan::route('/create'),
            'edit' => EditSertifikatPerusahaan::route('/{record}/edit'),
        ];
    }
}
