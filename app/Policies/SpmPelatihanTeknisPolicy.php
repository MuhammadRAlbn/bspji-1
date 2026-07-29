<?php

namespace App\Policies;

use App\Models\SpmPelatihanTeknis;
use App\Models\User;

class SpmPelatihanTeknisPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmPelatihanTeknis $spmPelatihanTeknis): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmPelatihanTeknis::query()->exists();
    }

    public function update(User $user, SpmPelatihanTeknis $spmPelatihanTeknis): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmPelatihanTeknis $spmPelatihanTeknis): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
