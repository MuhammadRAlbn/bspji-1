<?php

namespace App\Policies;

use App\Models\SpmTkdn;
use App\Models\User;

class SpmTkdnPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmTkdn $spmTkdn): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmTkdn::query()->exists();
    }

    public function update(User $user, SpmTkdn $spmTkdn): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmTkdn $spmTkdn): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
