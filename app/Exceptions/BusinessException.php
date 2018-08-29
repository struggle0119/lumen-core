<?php
/**
 * Author: guojinli
 * Date: 2018-04-28
 * Description: fucking what?
 */

namespace App\Exceptions;

class BusinessException extends \Exception
{
    public function __construct($code, $message = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}