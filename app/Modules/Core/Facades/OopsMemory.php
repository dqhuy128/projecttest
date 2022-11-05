<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 13:33:50
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 13:35:00
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class OopsMemory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OopsMemory';
    }
}