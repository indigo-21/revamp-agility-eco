<?php

namespace App\Services;

use App\Models\Navigation;
use App\Models\UserNavigation;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class PostLoginRedirectService
{
    public function permissionForLink(User $user, string $link): int
    {
        $navigationId = Navigation::where('link', $link)->value('id');
        if (!$navigationId) {
            return 0;
        }

        return (int) (UserNavigation::query()
            ->where('account_level_id', $user->account_level_id)
            ->where('navigation_id', $navigationId)
            ->value('permission') ?? 0);
    }

    public function preferredLandingRouteName(User $user): ?string
    {
        // Prefer common landing pages first, then fall back to the first available navigation link.
        $preferredLinks = [
            'installer-dashboard',
            'pi-dashboard',
            'dashboard',
            'job', // "Manage Jobs" (JobController@index)
        ];

        foreach ($preferredLinks as $link) {
            if ($this->permissionForLink($user, $link) > 0) {
                $routeName = $this->routeNameForLink($link);
                if ($routeName !== null) {
                    return $routeName;
                }
            }
        }

        $firstAccessibleLink = Navigation::query()
            ->whereNotNull('link')
            ->where('link', '!=', '')
            ->whereHas('userNavigations', function ($q) use ($user) {
                $q->where('account_level_id', $user->account_level_id)
                    ->where('permission', '>', 0);
            })
            ->orderBy('id')
            ->value('link');

        if (!$firstAccessibleLink) {
            return null;
        }

        return $this->routeNameForLink($firstAccessibleLink);
    }

    public function preferredLandingUrl(User $user, bool $absolute = false): ?string
    {
        $routeName = $this->preferredLandingRouteName($user);
        if ($routeName === null) {
            return null;
        }

        return route($routeName, absolute: $absolute);
    }

    private function routeNameForLink(string $link): ?string
    {
        // Most navigations map to resource index routes, e.g. "job" -> "job.index".
        $indexRouteName = $link . '.index';
        if (Route::has($indexRouteName)) {
            return $indexRouteName;
        }

        // Some navigations may map to a single named route.
        if (Route::has($link)) {
            return $link;
        }

        return null;
    }
}
