<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Navigation;

class NavigationAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $routeName): Response
    {
        $user = Auth::user();

        // Find the navigation by route name (link)
        $navigation = Navigation::where('link', $routeName)->first();

        if (!$navigation) {
            abort(404);
        }

        // Check if user has access
        $hasAccess = $navigation->userNavigations()
            ->where('account_level_id', $user->accountLevel->id)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
