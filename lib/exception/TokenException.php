<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/2
 * Time: 12:00
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效Token';
    public $errorCode = 10001;
}