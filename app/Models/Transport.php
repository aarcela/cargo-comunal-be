<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

class Transport extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_user_transporte';
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
        'id_user_transporte',
        'id_user',
        'nro_placa',
        'marca',
        'modelo',
        'carnet_circulacion',
        'carga_maxima',
        'tipo',
        'estado',  // 'pendiente' | 'aprobado' | 'cancelado'
        'fecha_creado',
        'fecha_editado'
    ];


    protected $table = 'usuarios_transportes';

    const CREATED_AT = 'fecha_creado';
    const UPDATED_AT = 'fecha_editado';

    protected $casts = [
        'fecha_creado_transport' => 'datetime:d/m/Y',
        'fecha_creado' => 'datetime:d/m/Y',
        'fecha_editado' => 'datetime:d/m/Y',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id_user_transporte = (string)Uuid::generate(4);
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function profile()
    {
        $this->hasOne(Profile::class, 'id_user', 'id_user');
    }
}
