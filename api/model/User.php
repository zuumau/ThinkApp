<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/31
 * Time: 17:42
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openid) {
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }
}