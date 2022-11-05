<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 12:52:47
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 12:54:57
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ClassDoesNotExistException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Class does not exist.';

}