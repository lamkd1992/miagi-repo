<?php
namespace Miagi\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Miagi\Repository\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../resources/config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../resources/config/repository.php', 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Miagi\Repository\Generators\Commands\RepositoryCommand');
        $this->app->register('Miagi\Repository\Providers\EventServiceProvider');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
