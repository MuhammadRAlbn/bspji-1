<?php

namespace App\Policies;

use App\Models\SpmSertifikasiProduk;
use App\Models\User;

class SpmSertifikasiProdukPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SpmSertifikasiProduk $spmSertifikasiProduk): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() && ! SpmSertifikasiProduk::query()->exists();
    }

    public function update(User $user, SpmSertifikasiProduk $spmSertifikasiProduk): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SpmSertifikasiProduk $spmSertifikasiProduk): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
