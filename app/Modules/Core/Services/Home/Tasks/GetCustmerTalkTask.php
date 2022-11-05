<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 17:50:54
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 12:10:52
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Services\Home\Tasks;

use App\Models\Customer;
use App\Modules\Core\Parents\Tasks\Task;

class GetCustmerTalkTask extends Task
{
    public function run($limit)
    {
        try {
            return $this->remember(function () use ($limit) {
                $data = Customer::getFeedback($limit);
                return $data;
            });
        }catch(\Exception $e) {
            throw $e;
        }
    }
}
