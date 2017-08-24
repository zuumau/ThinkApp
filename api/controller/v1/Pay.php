<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/7/20
 * Time: 16:40
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    // 发起支付
    public function getPreOrder($id = '')
    {
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    // 接受微信服务器返回支付的通知
    public function receiveNotify()
    {
        // 通知频率为15/15/30/180/1800/1800/1800/1800/3600, 单位：秒

        // 1. 检测库存量
        // 2. 更新这个订单的status状态
        // 3. 减库存
        // 如果成功处理，我们返回微信处理结果的信息, 微信服务器停止通知

        // 特点：post; xml格式; 不会携带参数;
        $notify = new WxNotify();
        $notify->Handle();
    }

    public function redirectNotify(){
        $notify = new WxNotify();
        $notify->Handle();
    }
}

