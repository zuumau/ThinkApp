<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/7/4
 * Time: 16:16
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    // 读取器
    public function getSnapItemsAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value)
    {
        if (empty($value)) {
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid, $page=1, $size=15)
    {
        // 分页查询
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);

        return $pagingData;
    }
}