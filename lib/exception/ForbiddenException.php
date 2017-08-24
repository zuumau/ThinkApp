<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/14
 * Time: 10:32
 */

namespace app\lib\exceptionF;


use app\lib\exception\BaseException;

class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}