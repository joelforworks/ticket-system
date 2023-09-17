<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\PermissionExeception;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        $user = User::find(Auth::id());

        if (!in_array($user->role, $roles)) {
            // throw error
            throw new PermissionExeception(["Your user don't have permissions"]);
        }

        return $next($request);
    }
}
