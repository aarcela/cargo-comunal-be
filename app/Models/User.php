<?php

namespace App\Models;

use App\Casts\DateCast;
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
 * @method static find(int $id)
 * @method static create($validated)
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'username' => 'string',
        'email' => 'string',
        'activo' => 'boolean',
        'estado' => 'string',
        'role' => 'string',
        'ruta_image' => 'string',
        'created_at' => DateCast::class,
        'updated_at' => DateCast::class,
        'deleted_at' => DateCast::class
    ];


    public static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (!Hash::check($user->password, $user->password)) {
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
