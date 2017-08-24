<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/31
 * Time: 16:38
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return [
            'token' => $token
        ];
    }

    public static function getCurrentUid()
    {
        // token

    }
}