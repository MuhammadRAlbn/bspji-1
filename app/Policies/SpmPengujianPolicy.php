<?php

namespace App\Policies;

use App\Models\SpmPengujian;
use App\Models\User;

class SpmPengujianPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmPengujian $spmPengujian): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmPengujian::query()->exists();
    }

    public function update(User $user, SpmPengujian $spmPengujian): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmPengujian $spmPengujian): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
