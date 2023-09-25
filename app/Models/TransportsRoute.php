<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TransportsRoute extends Model
{
    use HasFactory;

    /**
     * Table's Name
     *
     * @var array<int, string>
     */
    protected $table = 'transports_route';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected  $fillable = [
        'transport_id ',
        'route_id ',
    ];

    protected $casts = [
        'transport_id' => 'integer',
        'route_id' => 'integer',
    ];


}
