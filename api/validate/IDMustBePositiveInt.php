<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/27
 * Time: 10:04
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];
}