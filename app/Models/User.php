<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user', 
        'username',
        'email',
        'password',
        'activo',
        'estado', // 'pendiente' | 'aprobado' | 'cancelado'
        'role', // "conductor" | "solicitante" | "administrador" | "analista"
        'ruta_image',
        'eliminado', 
        'fecha_creado', 
        'fecha_editado', 
        'fecha_eliminado', 
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
        'fecha_creado' => 'datetime:d/m/Y',
        'fecha_editado' => 'datetime:d/m/Y',
    ];

    protected $table = 'usuarios';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_user = (string) Uuid::generate(4);
        });
    }
}
