<?php

namespace App\Policies;

use App\Models\SpmLsih;
use App\Models\User;

class SpmLsihPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmLsih $spmLsih): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmLsih::query()->exists();
    }

    public function update(User $user, SpmLsih $spmLsih): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmLsih $spmLsih): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
