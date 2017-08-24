<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 15:01
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定类目不存在，请检查ID';
    public $errorCode = 50000;
}