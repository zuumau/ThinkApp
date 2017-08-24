<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/4
 * Time: 16:30
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}