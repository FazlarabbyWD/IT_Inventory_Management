<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Settings;
use View;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('settingsInfo', $this->settingsInfo());
    }

    public function settingsInfo(){
        return Settings::orderBy('id', 'desc')->first();
    }
}
