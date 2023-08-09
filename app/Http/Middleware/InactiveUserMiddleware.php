<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * @property Authenticatable|null $user
 */
class InactiveUserMiddleware extends Controller
{
    /**
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $this->user = Auth::user();
        if ($this->user !== null) {
            if ($this->user->active === false) {
                return $this->sendError('Inactive', ['error' => 'User is Inactive'], 403);
            }
        }

        return $next($request);
    }
}
