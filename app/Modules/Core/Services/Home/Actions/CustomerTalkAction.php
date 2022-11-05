<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:23:42
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 11:19:21
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Services\Home\Actions;

use App\Modules\Core\Parents\Actions\Action;

class CustomerTalkAction extends Action
{
    public function run($limit)
    {
        return $this->call('Home@GetCustmerTalkTask', [$limit]);
    }
}
