<?php

namespace App\Policies;

use App\Models\SpmLph;
use App\Models\User;

class SpmLphPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmLph $spmLph): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmLph::query()->exists();
    }

    public function update(User $user, SpmLph $spmLph): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmLph $spmLph): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
