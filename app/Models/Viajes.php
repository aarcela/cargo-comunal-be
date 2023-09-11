<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(mixed $validated)
 * @method static where(string $string, string $string1, $id)
 * @method static whereHas(string $string, \Closure $param)
 * @method static find(int $id)
 */
class Viajes extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table's Name
     *
     * @var array<int, string>
     */
    protected $table = 'viajes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected  $fillable = [
        'user_id',
        'transport_id',
        'ruta',
        'tiempo',
        'hora',
        'peso',
        'status',
        'latitud_origen',
        'longitud_origen',
        'latitud_destino',
        'longitud_destino'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'transport_id' => 'integer',
        'ruta' => 'string',
        'tiempo' => 'string',
        'hora' => TimeCast::class,
        'peso' => 'string',
        'status' => 'string',
        'latitud_origen' => 'string',
        'longitud_origen' => 'string',
        'latitud_destino' => 'string',
        'longitud_destino' => 'string'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function transport(): BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id');
    }
}
