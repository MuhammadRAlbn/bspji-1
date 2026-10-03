<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPanelAccess() && $user->isAdmin();
    }

    public function view(User $user, User $record): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, User $record): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, User $record): bool
    {
        return $this->viewAny($user)
            && ! $user->is($record)
            && (! $record->isAdmin() || ! $record->is_active || User::query()
                ->where('role', User::ROLE_ADMIN)
                ->where('is_active', true)
                ->where('id', '<>', $record->getKey())
                ->exists());
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }
}
