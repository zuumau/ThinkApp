<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/4
 * Time: 16:33
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'id'];
}