<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/1
 * Time: 14:46
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 404;
    public $msg = '指定类目不存在，请检查ID';
    public $errorCode = 50000;
}