<?php

namespace App\Filament\Clusters\Lsih;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class LsihCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'LSIH';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBeaker;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
