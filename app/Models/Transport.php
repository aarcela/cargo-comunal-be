<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Transport extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table's Name
     *
     * @var array<int, string>
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nro_placa',
        'marca',
        'modelo',
        'carnet_circulacion',
        'carga_maxima',
        'tipo',
        'estado',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'nro_placa' => 'string',
        'marca' => 'string',
        'modelo' => 'string',
        'carnet_circulacion' => 'string',
        'carga_maxima' => 'string',
        'tipo' => 'string',
        'estado' => 'string',
        'created_at' => DateCast::class,
        'updated_at' => DateCast::class,
        'deleted_at' => DateCast::class
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
