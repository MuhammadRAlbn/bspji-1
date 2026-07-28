<?php

namespace App\Policies;

use App\Models\SpmKalibrasi;
use App\Models\User;

class SpmKalibrasiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmKalibrasi $spmKalibrasi): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmKalibrasi::query()->exists();
    }

    public function update(User $user, SpmKalibrasi $spmKalibrasi): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmKalibrasi $spmKalibrasi): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
