<?php

namespace App\Filament\Clusters\Kalibrasi;

use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class KalibrasiCluster extends Cluster
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Kalibrasi';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
