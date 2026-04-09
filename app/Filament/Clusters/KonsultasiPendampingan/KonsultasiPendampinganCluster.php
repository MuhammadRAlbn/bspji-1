<?php

namespace App\Filament\Clusters\KonsultasiPendampingan;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Support\Icons\Heroicon;

class KonsultasiPendampinganCluster extends Cluster
{
    protected static string|\UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?string $navigationLabel = 'Konsultasi dan Pendampingan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
