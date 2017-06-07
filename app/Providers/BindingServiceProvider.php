<?php namespace App\Providers;

use App\Contracts\IHrefRepository;
use App\Contracts\ITagRepository;
use App\Repositories\HrefRepository;
use App\Repositories\TagRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class BindingServiceProvider
 * @package App\Providers
 */
class BindingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(ITagRepository::class, TagRepository::class);
        $this->app->bind(IHrefRepository::class, HrefRepository::class);
    }
}