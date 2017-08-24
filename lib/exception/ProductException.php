<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 11:21
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '指定的商品不存在';
    public $errorCode = 20000;
}