<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TimeCast implements CastsAttributes
{
    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return string|null
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        return Carbon::parse($value)->format('H:i:s');
    }

    /**
     * @param $model
     * @param string $key
     * @param $value
     * @param array $attributes
     * @return mixed|null
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        return $value;
    }
}
