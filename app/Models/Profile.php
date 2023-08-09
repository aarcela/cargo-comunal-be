<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        'first_name',
        'second_name',
        'first_surname',
        'second_surname',
        'phone',
        'ci',
        'fecha_nc',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'first_name' => 'string',
        'second_name' => 'string',
        'first_surname' => 'string',
        'second_surname' => 'string',
        'phone' => 'string',
        'ci' => 'string',
        'fecha_nc' => DateCast::class,
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
