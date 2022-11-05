<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 17:50:54
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-06-30 11:21:11
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Services\Feature\Tasks;

use App\Models\Feature;
use App\Modules\Core\Parents\Tasks\Task;

class GetSlidebyPositionTask extends Task
{
    public function run($position, $limit = 6, $lang = 'vi')
    {
        try {
            return $this->remember(function () use ($position, $limit, $lang) {
                $wery = Feature::getSlideByPositions($lang, $position)->orderBy('id', 'desc');

                return $limit > 1 ? $wery->limit($limit)->get() : $wery->first();
            });
        }catch(\Exception $e) {
            throw $e;
        }
    }
}
