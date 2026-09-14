<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'password_temp',
        'remember_token',
        'code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthday' => 'date',
            'password' => 'hashed',
        ];
    }

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }

    /**
     * Absolute URL des Profilbildes. Alte Datensätze enthalten entweder eine
     * externe URL oder einen Pfad relativ zum Web-Root ("/user/avatars/…").
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function () {
            $avatar = trim((string) $this->avatar);
            $fallback = 'https://api.dicebear.com/9.x/adventurer-neutral/svg?seed='.urlencode($this->name);

            if ($avatar === '') {
                return $fallback;
            }

            if (Str::startsWith($avatar, ['http://', 'https://', '//'])) {
                // Der frühere Platzhalter-Dienst existiert nicht mehr.
                return Str::contains($avatar, 'api.adorable.io') ? $fallback : $avatar;
            }

            $path = '/'.ltrim($avatar, '/');

            $exists = Str::startsWith($path, '/user/avatars/')
                ? Storage::disk('avatars')->exists(basename($path))
                : file_exists(public_path($path));

            return $exists ? $path : $fallback;
        });
    }

    /**
     * Darf dieser Benutzer die Teams auslosen?
     */
    public function canDraw(): bool
    {
        return in_array($this->name, config('fussballgoetter.drawers', []), true);
    }

    /**
     * Hat der Benutzer innerhalb der nächsten Tage (inkl. heute) Geburtstag?
     */
    public function hasBirthdayWithinDays(int $days = 6): bool
    {
        if (! $this->birthday) {
            return false;
        }

        $today = now()->startOfDay();
        $next = $this->birthday->copy()->year($today->year)->startOfDay();

        if ($next->lt($today)) {
            $next->addYear();
        }

        return $next->diffInDays($today, absolute: true) <= $days;
    }
}
