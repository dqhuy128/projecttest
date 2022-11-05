<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 17:40:36
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 11:33:11
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Abstracts\Tasks;

use App\Modules\Core\Traits\CacheableGlobalTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Cache\Repository;

abstract class Task
{
    use CacheableGlobalTrait;
    
    public function __construct()
    {
        $this->cacheTime = Config::get('cache.repo_time', 60);
        $this->enableCache = Config::get('app.cache', false);
        $this->cache = app(Repository::class);
        $this->locale = app()->getLocale();
    }
}
