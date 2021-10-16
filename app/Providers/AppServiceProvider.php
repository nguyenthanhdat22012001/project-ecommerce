<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Resources\Admin\Category;
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
//        Category::withoutWrapping();
    }
}
