<?php

namespace App\Models;

use App\Casts\DateCast;
use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
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
        'online',
        'latitude',
        'longitude',
        'connection_time',
        'connection_date',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'online' => 'boolean',
        'latitude' => 'string',
        'longitude' => 'string',
        'connection_time' => TimeCast::class,
        'connection_date' => DateCast::class,
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
