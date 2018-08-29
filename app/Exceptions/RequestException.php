<?php
/**
 * Author: guojinli
 * Date: 2018-05-05
 * Description: fucking what?
 */

namespace App\Exceptions;


class RequestException extends \Exception
{
    public function __construct($code, $message = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}