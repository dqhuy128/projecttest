<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2020-11-06 10:39:40
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 13:37:45
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Providers;

use App\Modules\BaseModuleServiceProvider;
use App\Modules\Core\StartUp\OopsMemory;

class CoreServiceProvider extends BaseModuleServiceProvider
{
    public function register()
    {
        $this->app->alias(OopsMemory::class, 'OopsMemory');

        $this->registerBinding();
        $this->registerProviders();
    }

    public function registerBinding()
    {
        
    }

    protected function registerProviders()
    {
    }
}
