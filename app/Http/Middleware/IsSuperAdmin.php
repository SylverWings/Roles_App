<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IsSuperAdmin
{
    const SUPER_ADMIN_ROLE = 3;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info("is Super Admin");

        $userId = auth()->user()->id;
        $user = User::find($userId);

        $hasRole = $user->roles->contains(self::SUPER_ADMIN_ROLE);

        if(!$hasRole){
            return response()->json(
                [
                    "success"=> true,
                    "message"=> "Dont have permissions"
                ],
                400
            );
        }

        return $next($request);
    }
}
