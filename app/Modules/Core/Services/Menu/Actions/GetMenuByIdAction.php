<?php

/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:23:42
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 14:08:28
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Services\Menu\Actions;

use App\Models\Menu;
use App\Modules\Core\Parents\Actions\Action;

class GetMenuByIdAction extends Action
{
    public function run($safe_title,$type)
    {
        return Menu::getMenuByID($safe_title, $type);
    }
}