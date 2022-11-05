<?php
/**
 * @ Created by: VSCode
 * @ Author: Oops!Memory - OopsMemory.com
 * @ Create Time: 2021-03-25 12:52:47
 * @ Modified by: Oops!Memory - OopsMemory.com
 * @ Modified time: 2021-03-25 12:55:46
 * @ Description: Happy Coding!
 */

namespace App\Modules\Core\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class UndefinedTransporterException extends Exception
{

    public $httpStatusCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Default Transporter for Request not defined. Please override $transporter in Ship\Parents\Request\Request.';

}
