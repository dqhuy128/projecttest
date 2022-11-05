<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:36:58
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 13:43:14
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Parents\Actions;

use App\Modules\Core\Abstracts\Actions\Action as AbstractAction;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Config\Repository as ConfigRepository;

abstract class Action extends AbstractAction
{
    public function __construct()
    {
        $this->cache = app(Repository::class);
        $this->cacheTime = app(ConfigRepository::class)->get('cache.repo_time', 60);
        $this->locale = app()->getLocale();
    }
}
