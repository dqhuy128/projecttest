<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:23:42
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 11:19:21
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Services\Feature\Actions;

use App\Modules\Core\Parents\Actions\Action;

class SlideByPositionAction extends Action
{
    public function run($position, $limit = 6,$lang = 'vi')
    {
        return $this->call('Feature@GetSlidebyPositionTask',[$position,$limit,$lang]);
    }
}
