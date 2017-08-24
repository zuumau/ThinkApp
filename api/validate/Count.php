<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 10:18
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];
}