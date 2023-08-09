<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Location extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user_location';
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
        'id_user_location',
        'id_user',
        'online',
        'latitude',
        'longitude',
        'hora_conection',
        'fecha_conection',
        'fecha_creado',
        'fecha_editado'
    ];


    protected $table = 'usuarios_location';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_user_location = (string) Uuid::generate(4);
        });
    }
}
