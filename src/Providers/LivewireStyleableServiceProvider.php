<?php

namespace Jey\LivewireStyleable\Providers;

use Illuminate\Support\ServiceProvider;
use Jey\LivewireStyleable\Styleable;
use Livewire\LifecycleManager;

class LivewireStyleableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        LifecycleManager::registerInitialDehydrationMiddleware([
            [Styleable::class, 'dehydration'],
        ]);

        $this->mergeConfigFrom(
            __DIR__ .'/../config/styleable.php', 'styleable',
        );

        $this->publishes([
            __DIR__ .'/../config/styleable.php' => config_path('styleable'),
        ], 'styleable');
    }
}
