<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed|string $username
 * @property mixed|string $email
 * @property mixed|string $password
 * @property mixed|string $estado
 * @property mixed|string $role
 * @property mixed $id
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * Table's Name
     *
     * @var array<int, string>
     */
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'activo',
        'estado', // 'pendiente' | 'aprobado' | 'cancelado'
        'role', // "conductor" | "solicitante" | "administrador" | "analista"
        'ruta_image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
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


    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (!Hash::info($user->password)['algoName']) {
                $user->password = Hash::make($user->password);
            }
        });
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'user_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function transport(): HasOne
    {
        return $this->hasOne(Transport::class, 'user_id', 'id');
    }
}
