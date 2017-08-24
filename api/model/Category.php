<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 14:52
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];
    public function img() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}