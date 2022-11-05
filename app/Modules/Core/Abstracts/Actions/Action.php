<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 10:33:02
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 13:43:47
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Abstracts\Actions;

use App\Modules\Core\Traits\CallableTrait;

abstract class Action
{

    use CallableTrait;

    /**
     * Set automatically by the controller after calling an Action.
     * Allows the Action to know which UI invoke it, to modify it's behaviour based on it, when needed.
     *
     * @var string
     */
    protected $ui;

    /**
     * @param $interface
     *
     * @return  $this
     */
    public function setUI($interface)
    {
        $this->ui = $interface;

        return $this;
    }

    /**
     * @return  mixed
     */
    public function getUI()
    {
        return $this->ui;
    }
}
