<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property mixed $user_id
 * @property mixed|string $first_name
 * @property mixed|string $second_name
 * @property mixed|string $first_surname
 * @property mixed|string $second_surname
 * @property mixed|string $phone
 * @property mixed|string $ci
 * @property mixed|string $fecha_nc
 */
class Profile extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_profile';
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
        'id_profile',
        'id_user',
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'phone',
        'ci',
        'fecha_nc',
        'fecha_creado',
        'fecha_editado',
    ];


    protected $table = 'usuarios_profile';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_profile = (string) Uuid::generate(4);
        });
    }
}
