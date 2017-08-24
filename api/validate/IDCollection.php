<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/24
 * Time: 17:01
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是逗号分隔的多个正整数'
    ];

    // ids = id1,id2...
    protected function checkIDs($value) {
        $value = explode(',', $value);
        if (empty($value)) {
            return false;
        }
        foreach ($value as $id) {
            if(!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }
}