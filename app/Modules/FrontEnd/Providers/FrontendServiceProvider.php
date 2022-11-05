<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2020-11-06 10:39:40
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 13:29:26
 * @ Description: Happy Coding!
 */

namespace App\Modules\FrontEnd\Providers;

use App\Modules\BaseModuleServiceProvider;

class FrontendServiceProvider extends BaseModuleServiceProvider
{
    public function register()
    {
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
