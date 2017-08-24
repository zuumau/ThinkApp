<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/24
 * Time: 15:44
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];
    // 建立与主题图片的关联
    public function topicImg()
    {
        // $this->hasOne()
        // 一对一 不对等 关联
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    // 建立与头部图片的关联
    public function headImg()
    {
        // 一对一关联
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products()
    {
        // 多对多关联   参数 (模型、中间表、关联模型id、本模型id)
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}