<?php

namespace App\Filament\Clusters\LembagaPemeriksaHalal;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class LembagaPemeriksaHalalCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Lembaga Pemeriksa Halal';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;
}
