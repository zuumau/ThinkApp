<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/31
 * Time: 16:40
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code 不能获取Token'
    ];
}