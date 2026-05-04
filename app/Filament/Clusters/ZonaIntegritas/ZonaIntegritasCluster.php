<?php

namespace App\Filament\Clusters\ZonaIntegritas;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class ZonaIntegritasCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Landing Page';

    protected static ?string $navigationLabel = 'Zona Integritas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
