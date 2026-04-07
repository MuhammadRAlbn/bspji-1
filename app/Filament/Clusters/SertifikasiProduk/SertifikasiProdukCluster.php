<?php

namespace App\Filament\Clusters\SertifikasiProduk;

use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class SertifikasiProdukCluster extends Cluster
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Sertifikasi Produk';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
