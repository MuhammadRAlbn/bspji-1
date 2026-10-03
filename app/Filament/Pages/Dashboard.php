<?php

namespace App\Filament\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public static function shouldRegisterNavigation(): bool
    {
        return ! Filament::auth()->user()?->isPengaduanStaff() && parent::shouldRegisterNavigation();
    }

    public static function canAccess(): bool
    {
        return (bool) Filament::auth()->user()?->hasPanelAccess();
    }

    public function getWidgets(): array
    {
        return Filament::auth()->user()?->isPengaduanStaff() ? [] : parent::getWidgets();
    }
}
