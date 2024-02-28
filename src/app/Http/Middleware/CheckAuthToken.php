<?php

namespace App\Http\Middleware;

use App\Enums\HttpStatus;
use App\Response\ApiResponse;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthToken
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return ApiResponse::response(HttpStatus::HTTP_UNAUTHORIZED, 'Authentication failed');
        }

        return $next($request);
    }
}
