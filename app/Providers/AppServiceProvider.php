<?php

namespace App\Providers;

use App\Models\Navigation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Force HTTPS in production or when FORCE_HTTPS is true
        if (config('app.env') === 'production' || 
            env('FORCE_HTTPS', false) || 
            request()->isSecure()) {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $user = auth()->user();

            if ($user === null) {
                return;
            }

            $navigations = Navigation::whereHas('userNavigations', function ($q) use ($user) {
                $q->where('account_level_id', $user->accountLevel->id);
            })->with([
                        'userNavigations' => function ($q) use ($user) {
                            $q->where('account_level_id', $user->accountLevel->id);
                        }
                    ])->get();


            $currentLink = request()->segment(1);
            $userPermission = $navigations
                ->where('link', $currentLink)
                ->first()
                ?->userNavigations
                ->first()
                    ?->permission ?? 1;

            $view->with('navigations', $navigations)
                ->with('userPermission', $userPermission);
        });
    }
}
