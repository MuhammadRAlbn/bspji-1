<?php

namespace App\Filament\Clusters\PelatihanTeknis;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class PelatihanTeknisCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Pelatihan Teknis';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
