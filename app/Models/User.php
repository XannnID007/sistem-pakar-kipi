<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship with RiwayatDiagnosa
     * Satu user bisa memiliki banyak riwayat diagnosa
     */
    public function riwayatDiagnosa()
    {
        return $this->hasMany(RiwayatDiagnosa::class);
    }

    /**
     * Check if user is pakar
     */
    public function isPakar()
    {
        return $this->role === 'pakar';
    }

    /**
     * Check if user is pengguna
     */
    public function isPengguna()
    {
        return $this->role === 'pengguna';
    }

    /**
     * Check if user is kepala puskesmas
     */
    public function isKepalaPuskesmas()
    {
        return $this->role === 'kepala_puskesmas';
    }
}
