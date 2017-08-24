<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/28
 * Time: 12:02
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的Banner不存在';
    public $errorCode = 40000;
}