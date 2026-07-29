<?php

namespace App\Policies;

use App\Models\SpmKonsultasiPendampingan;
use App\Models\User;

class SpmKonsultasiPendampinganPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmKonsultasiPendampingan $spmKonsultasiPendampingan): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmKonsultasiPendampingan::query()->exists();
    }

    public function update(User $user, SpmKonsultasiPendampingan $spmKonsultasiPendampingan): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmKonsultasiPendampingan $spmKonsultasiPendampingan): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
