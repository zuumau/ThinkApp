<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/12
 * Time: 11:24
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}