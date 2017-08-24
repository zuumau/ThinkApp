<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/26
 * Time: 16:59
 */

namespace app\api\validate;
use think\Validate;
class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email'
    ];
}