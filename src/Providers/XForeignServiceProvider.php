<?php

namespace Hotash\XForeign\Providers;

use Hotash\XForeign\Database\Schema\BlueprintMixin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class XForeignServiceProvider extends ServiceProvider
{
    protected array $mixins = [
        Blueprint::class => BlueprintMixin::class,
    ];

    protected array $testingMixins = [
        //
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMixins($this->mixins);

        if ($this->app->environment('testing')) {
            $this->registerMixins($this->testingMixins);
        }

        $this->mergeConfigFrom(__DIR__.'/../../config/x-foreign.php', 'x-foreign');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerMixins($mixins)
    {
        foreach ($mixins as $class => $mixin) {
            if (! is_array($mixin)) {
                $mixin = [$mixin];
            }

            foreach ($mixin as $item) {
                $class::mixin(new $item);
            }
        }
    }
}
