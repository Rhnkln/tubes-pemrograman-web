<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'nim',
        'alamat',
        'foto_profil',
        'role_id',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi: User memiliki satu Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi: User memiliki banyak lost items
     */
    public function lostItems()
    {
        return $this->hasMany(LostItem::class);
    }

    /**
     * Relasi: User memiliki banyak found items
     */
    public function foundItems()
    {
        return $this->hasMany(FoundItem::class);
    }

    /**
     * Relasi: User memiliki banyak laporan (reports)
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role_id === Role::where('name', 'admin')->first()?->id;
    }

    /**
     * Cek apakah user adalah user biasa
     */
    public function isUser(): bool
    {
        return $this->role_id === Role::where('name', 'user')->first()?->id;
    }
}
