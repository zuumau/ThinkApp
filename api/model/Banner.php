<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/27
 * Time: 16:21
 */

namespace app\api\model;

use think\Db;
use think\Exception;
use think\Model;

class Banner extends Model
{
    protected $hidden = ['delete_time', 'update_time'];      // 隐藏字段
    // protected $visible = ['id'];        // 只显示指定字段

    // 建立关联
    public function items()
    {
        // 一对多关系
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /* 可以继续关联其它模型
    public function items1() {}
    */

    // protected $table = 'category';  // 查询其它表
    public static function getBannerByID($id)
    {
        // 关联多个模型时， with()中填写数组 with(['items','items1'])  也可以嵌套使用
        $banner = self::with(['items', 'items.img'])->find($id);

        return $banner;
    }
}