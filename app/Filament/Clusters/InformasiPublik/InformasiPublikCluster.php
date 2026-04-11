<?php

namespace App\Filament\Clusters\InformasiPublik;

use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class InformasiPublikCluster extends Cluster
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Informasi';

    protected static ?string $navigationLabel = 'Informasi Publik';

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
