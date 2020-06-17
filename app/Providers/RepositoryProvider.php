<?php

namespace App\Providers;

use App\Repositories\EbayCallRepo;
use App\Repositories\ExcludeSellerRepo;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ExcludeSellerInterface;
use App\Repositories\Interfaces\ItemInterface;
use App\Repositories\ItemRepo;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ExcludeCategoryInterface;
use App\Repositories\ExcludeCategoryRepo;
use App\Repositories\Interfaces\ExcludeKeywordsInterface;
use App\Repositories\ExcludeKeywordsRepo;

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
        $this->registerExcludeSeller();
        $this->registerExcludeCategory();
        $this->registerKeyword();
    }

    public function registerKeyword()
    {
        $this->app->bind(
            ExcludeKeywordsInterface::class,
            ExcludeKeywordsRepo::class
        );
    }

    public function registerExcludeCategory()
    {
        $this->app->bind(
            ExcludeCategoryInterface::class,
            ExcludeCategoryRepo::class
        );
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

    public function registerExcludeSeller()
    {
        $this->app->bind(
            ExcludeSellerInterface::class,
            ExcludeSellerRepo::class
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
