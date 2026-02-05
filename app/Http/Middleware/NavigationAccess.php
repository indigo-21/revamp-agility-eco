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
    public function handle(Request $request, Closure $next, string $routeName, ?string $requiredPermissionOverride = null): Response
    {
        $user = Auth::user();

        $routeNames = collect(preg_split('/[|,]/', $routeName))
            ->map(fn ($v) => trim((string) $v))
            ->filter();

        // Permission required depends on the action unless explicitly overridden.
        // 1: read, 2: write, 3: full access
        if ($requiredPermissionOverride !== null && is_numeric($requiredPermissionOverride)) {
            $requiredPermission = max(1, min(3, (int) $requiredPermissionOverride));
        } else {
            $method = strtoupper($request->getMethod());
            $requiredPermission = match ($method) {
                'GET', 'HEAD' => 1,
                'DELETE' => 3,
                default => 2,
            };
        }

        $maxPermission = 0;

        foreach ($routeNames as $link) {
            $navigation = Navigation::where('link', $link)->first();
            if (!$navigation) {
                continue;
            }

            $permission = (int) ($navigation->userNavigations()
                ->where('account_level_id', $user->accountLevel->id)
                ->value('permission') ?? 0);

            $maxPermission = max($maxPermission, $permission);
        }

        if ($maxPermission < $requiredPermission) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
