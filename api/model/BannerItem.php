<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/20
 * Time: 15:30
 */

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['id','img_id','banner_id','delete_time', 'update_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}