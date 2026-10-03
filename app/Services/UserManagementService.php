<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserManagementService
{
    public function create(User $actor, array $data): User
    {
        Gate::forUser($actor->fresh())->authorize('create', User::class);

        return User::create($this->validate($data));
    }

    public function update(User $actor, User $record, array $data): User
    {
        return DB::transaction(function () use ($actor, $record, $data): User {
            $users = $this->lockedAccounts($actor, $record);
            $currentActor = $users->find($actor->getKey());
            $currentRecord = $users->find($record->getKey());
            abort_unless($currentActor && $currentRecord, 403);
            Gate::forUser($currentActor)->authorize('update', $currentRecord);

            $data = $this->validate($data, $currentRecord);
            $role = $data['role'] ?? $currentRecord->role;
            $active = $data['is_active'] ?? $currentRecord->is_active;

            if ($currentActor->is($currentRecord)) {
                if ($role !== User::ROLE_ADMIN) {
                    throw ValidationException::withMessages(['role' => 'Anda tidak dapat menurunkan role akun Anda sendiri.']);
                }
                if (! $active) {
                    throw ValidationException::withMessages(['is_active' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.']);
                }
            }

            if ($currentRecord->isAdmin() && $currentRecord->is_active && ($role !== User::ROLE_ADMIN || ! $active)) {
                $otherAdmin = $users->contains(fn (User $user): bool => ! $user->is($currentRecord) && $user->isAdmin() && $user->is_active);
                if (! $otherAdmin) {
                    throw ValidationException::withMessages(['role' => 'Setidaknya satu akun admin harus tetap aktif.']);
                }
            }

            $currentRecord->fill($data)->save();

            return $currentRecord;
        });
    }

    public function delete(User $actor, User $record): bool
    {
        return DB::transaction(function () use ($actor, $record): bool {
            $users = $this->lockedAccounts($actor, $record);
            $currentActor = $users->find($actor->getKey());
            $currentRecord = $users->find($record->getKey());
            abort_unless($currentActor && $currentRecord, 403);
            Gate::forUser($currentActor)->authorize('delete', $currentRecord);

            abort_if($currentActor->is($currentRecord), 403);
            if ($currentRecord->isAdmin() && $currentRecord->is_active) {
                abort_unless($users->contains(fn (User $user): bool => ! $user->is($currentRecord) && $user->isAdmin() && $user->is_active), 403);
            }

            if (! $currentRecord->delete()) {
                return false;
            }

            Password::deleteToken($currentRecord);
            if (config('session.driver') === 'database') {
                DB::connection(config('session.connection'))
                    ->table(config('session.table', 'sessions'))
                    ->where('user_id', $currentRecord->getKey())
                    ->delete();
            }

            return true;
        });
    }

    private function lockedAccounts(User $actor, User $record): Collection
    {
        return User::query()
            ->where(fn ($query) => $query->where('role', User::ROLE_ADMIN)->orWhereIn('id', [$actor->getKey(), $record->getKey()]))
            ->orderBy('id')
            ->lockForUpdate()
            ->get();
    }

    private function validate(array $data, ?User $record = null): array
    {
        $rules = [
            'name' => [$record ? 'sometimes' : 'required', 'required', 'string', 'max:255'],
            'email' => [$record ? 'sometimes' : 'required', 'required', 'email', 'max:255', Rule::unique(User::class)->ignore($record)],
            'role' => [$record ? 'sometimes' : 'required', 'required', Rule::in(User::panelRoles())],
            'is_active' => ['sometimes', 'boolean'],
            'password' => [$record ? 'nullable' : 'required', 'string', 'min:12', 'confirmed'],
        ];
        $validated = Validator::make($data, $rules)->validate();
        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        }

        return Arr::only($validated, ['name', 'email', 'role', 'is_active', 'password']);
    }
}
