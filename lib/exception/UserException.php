<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/11
 * Time: 16:26
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}