<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const string ROLE_ADMIN = 'admin';

    public const string ROLE_HUMAS = 'humas';

    public const string ROLE_FAP = 'fap';

    public const string ROLE_KEPALA_BALAI = 'kepala_balai';

    public const string ROLE_UNASSIGNED = 'unassigned';

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => self::ROLE_UNASSIGNED,
        'is_active' => true,
    ];

    /**
     * @return array<int, string>
     */
    public static function panelRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_HUMAS,
            self::ROLE_FAP,
            self::ROLE_KEPALA_BALAI,
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin' && $this->hasPanelAccess();
    }

    public function hasPanelAccess(): bool
    {
        return $this->is_active && in_array($this->role, self::panelRoles(), true);
    }

    public function isPengaduanStaff(): bool
    {
        return in_array($this->role, [self::ROLE_FAP, self::ROLE_KEPALA_BALAI], true);
    }

    public static function roleOptions(): array
    {
        return [self::ROLE_ADMIN => 'Admin', self::ROLE_HUMAS => 'Humas', self::ROLE_FAP => 'FAP', self::ROLE_KEPALA_BALAI => 'Kepala Balai'];
    }

    public static function roleDescription(?string $role): string
    {
        return match ($role) {
            self::ROLE_ADMIN => 'Mengelola akun dan seluruh fitur admin sesuai aturan masing-masing fitur.',
            self::ROLE_HUMAS => 'Mengelola berita dan komentar berita.',
            self::ROLE_FAP => 'Melihat pengaduan dan mengubah status, hasil tindak lanjut, serta dokumen hasil. Tidak dapat menghapus pengaduan.',
            self::ROLE_KEPALA_BALAI => 'Melihat daftar, detail, dokumen pengaduan, dan riwayat penghapusan. Tidak dapat mengubah atau menghapus data.',
            default => 'Pilih role untuk melihat izin aksesnya.',
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isHumas(): bool
    {
        return $this->role === self::ROLE_HUMAS;
    }

    public function canManageNewsContent(): bool
    {
        return $this->isAdmin() || $this->isHumas();
    }
}
