<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/27
 * Time: 09:52
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Theme 主题 不存在';
    public $errorCode = 30000;
}