<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Navigation;
use App\Models\NavigationAuditLog;

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
        $foundAnyNavigation = false;
        $matchedNavigationId = null;
        $matchedLink = null;

        foreach ($routeNames as $link) {
            $navigation = Navigation::where('link', $link)->first();
            if (!$navigation) {
                continue;
            }

            $foundAnyNavigation = true;

            $permission = (int) ($navigation->userNavigations()
                ->where('account_level_id', $user->accountLevel->id)
                ->value('permission') ?? 0);

            if ($permission >= $maxPermission) {
                $maxPermission = $permission;
                $matchedNavigationId = $navigation->id;
                $matchedLink = $navigation->link;
            }
        }

        if (!$foundAnyNavigation) {
            abort(404);
        }

        $route = $request->route();
        $routeNameResolved = is_object($route) ? $route->getName() : null;

        $baseLogPayload = [
            'user_id' => $user?->id,
            'account_level_id' => $user?->account_level_id,
            'navigation_id' => $matchedNavigationId,
            'navigation_link' => $matchedLink,
            'route_name' => $routeNameResolved,
            'uri' => '/' . ltrim($request->path(), '/'),
            'method' => strtoupper($request->getMethod()),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->headers->get('referer'),
            'required_permission' => $requiredPermission,
            'granted_permission' => $maxPermission,
        ];

        if ($maxPermission < $requiredPermission) {
            NavigationAuditLog::create(array_merge($baseLogPayload, [
                'allowed' => false,
                'status_code' => 403,
            ]));
            abort(403, 'Unauthorized');
        }

        $response = $next($request);

        NavigationAuditLog::create(array_merge($baseLogPayload, [
            'allowed' => true,
            'status_code' => method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
        ]));

        return $response;
    }
}
