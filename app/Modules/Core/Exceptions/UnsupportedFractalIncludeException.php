<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 12:52:47
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 12:56:03
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UnsupportedFractalIncludeException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_BAD_REQUEST;

    public $message = 'Requested a invalid Include Parameter.';

}
