<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(mixed $validated)
 * @method static where(string $string, string $string1, int $id)
 * @method static find(int $id)
 * @method static select(string $string)
 */
class Route extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table's Name
     *
     * @var array<int, string>
     */
    protected $table = 'routes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'description'
    ];

    protected $casts = [
        'nombre' => 'string',
        'description' => 'string'
    ];
}
