<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/4
 * Time: 11:04
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}