<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();
        $hasAccess = false;

        switch ($type) {
            case 'webmaster':
                $hasAccess = $user->isWebmaster();
                break;
            case 'admin':
                $hasAccess = $user->hasAdminPrivileges();
                break;
            case 'market_admin':
                $hasAccess = $user->hasMarketAdminPrivileges();
                break;
            case 'branch_admin':
                $hasAccess = $user->hasBranchAdminPrivileges();
                break;
            case 'user':
                $hasAccess = $user->hasUserPanelAccess();
                break;
            case 'guest':
                $hasAccess = $user->hasPublicContentAccess();
                break;
        }

        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 