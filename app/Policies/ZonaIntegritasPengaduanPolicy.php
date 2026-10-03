<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ZonaIntegritasPengaduan;

class ZonaIntegritasPengaduanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPanelAccess() && ($user->isAdmin() || $user->isPengaduanStaff());
    }

    public function view(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return $user->hasPanelAccess() && in_array($user->role, [User::ROLE_ADMIN, User::ROLE_FAP], true);
    }

    public function delete(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return $this->deleteAny($user);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPanelAccess() && $user->isAdmin();
    }

    public function replicate(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return false;
    }

    public function restore(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return false;
    }

    public function forceDelete(User $user, ZonaIntegritasPengaduan $record): bool
    {
        return false;
    }
}
