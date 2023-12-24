<?php

namespace App\Providers;

use App\Services\RandomApiService;
use Illuminate\Support\ServiceProvider;

class RandomApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RandomApiService::class, function () {
            return new RandomApiService();
        });
    }
}
