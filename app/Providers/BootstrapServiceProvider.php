<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([base_path('vendor/select2/select2/dist') => public_path('vendor/select2'),
        ], 'public');

        $this->publishes([base_path('vendor/nnnick/chartjs/dist') => public_path('vendor/chartjs'),
        ], 'public');
    }
}
