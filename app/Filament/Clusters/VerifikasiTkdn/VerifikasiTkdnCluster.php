<?php

namespace App\Filament\Clusters\VerifikasiTkdn;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class VerifikasiTkdnCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Verifikasi TKDN';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
