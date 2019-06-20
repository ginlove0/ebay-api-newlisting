<?php

namespace App\Providers;

use App\Repositories\EbayCallRepo;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\ItemRepo;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->registerEbayCall();
        $this->registerItem();
    }

    public function registerEbayCall()
    {
        $this->app->bind(
            EbayCallInterface::class,
            EbayCallRepo::class
        );
    }

    public function registerItem()
    {
        $this->app->bind(
            ItemInterface::class,
            ItemRepo::class
        );
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
}
