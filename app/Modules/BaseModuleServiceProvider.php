<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2020-11-06 10:19:14
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2020-12-07 14:36:03
 * @ Description: Happy Coding!
 */

namespace App\Modules;

use Illuminate\Support\ServiceProvider;

abstract class BaseModuleServiceProvider extends ServiceProvider
{
    protected $is_cache = false;
    public function __construct($app)
    {
        parent::__construct($app);
        $this->is_cache = config('app.cache');
    }
    /**
     * Booting the package.
     */
    public function boot()
    {
    }

    /**
     * Register all modules.
     */
    public function register()
    {
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
    }

    /**
     * Register the service provider.
     */
    protected function registerServices()
    {
    }

    abstract protected function registerBinding();

    /**
     * Register providers.
     */
    abstract protected function registerProviders();
}
