<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FrontpageSetting;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('fp', FrontpageSetting::first());
        });
    }
}
