<?php

namespace App\Filament\Clusters\Pengujian;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class PengujianCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    // protected static ?string $navigationGroup = 'Pelayanan';
    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Pengujian';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
