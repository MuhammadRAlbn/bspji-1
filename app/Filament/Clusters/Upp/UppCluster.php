<?php

namespace App\Filament\Clusters\Upp;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class UppCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Informasi';

    protected static ?string $navigationLabel = 'UPP';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
