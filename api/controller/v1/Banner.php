<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/4/26
 * Time: 16:18
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;
use think\Log;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     */
    public function getBanner($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        // 关联多个模型时， with()中填写数组 with(['items','items1'])  也可以嵌套使用
        // $banner = BannerModel::with(['items', 'items.img'])->find($id);
        // $banner = new BannerModel();
        // $banner = $banner->get($id);
        $banner = BannerModel::getBannerByID($id);
        // $banner->hidden(['delete_time', 'update_time']);   // 隐藏某些字段
        // $banner->visible(['id', 'update_time']);           // 只显示某些字段
        // $data = $banner->toArray();                        // 拿到数据并转为数组
        // unset($data['delete_time']);                       // 删除 字段

        if (!$banner) {
            throw new BannerMissException();
        }

        return $banner;
    }

}
