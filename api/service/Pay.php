<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/7/21
 * Time: 10:10
 */

namespace app\api\service;


use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;

// 引入WxPaySDK (引入没有命名空间的类)
use think\Loader;
use think\Log;

// extend/WxPay/WxPay.Api.php
// 'WxPay(文件夹).WxPay(文件名)',EXTEND_PATH(extend文件夹),'.Api.php(文件后缀)'
Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');


class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if (!$orderID)
        {
            throw new Exception('订单号不允许为NULL');
        }
        $this->orderID = $orderID;
    }

    public function pay()
    {
        // 订单号可能根本不存在
        // 订单号存在，但是 订单号与当前用户是不匹配的
        // 订单有可能已经被支付过
        $this->checkOrderValid();

        // 进行库存量检测
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);

        if (!$status['pass']) {
            return $status;
        }   

        return $this->makeWxPreOrder($status['orderPrice']);
    }

    // 生成 微信支付统一 订单对象
    private  function makeWxPreOrder($totalPrice)
    {
        $openid = Token::getCurrentTokenVar('openid');
        if (!$openid) {
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);      // 设置订单号
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);        // 设置总金额
        $wxOrderData->SetBody('名嘉汇');
        $wxOrderData->SetOpenid($openid);                   // 指定用户身份标示
        $wxOrderData->SetNotify_url('secure.pay_back_url');       // 接受回调接口

        return $this->getPaySignature($wxOrderData);
    }

    // 返回 支付签名
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' ||
            $wxOrder['result_code'] !='SUCCESS')
        {
            Log::record($wxOrder, 'error');
            Log::record('获取预支付订单失败', 'error');
        }
        // prepay_id

        $this->recordPreOrder($wxOrder);         // 保存 prepay_id
        $signature = $this->sign($wxOrder);

        return $signature;
    }

    private function sign($wxOrder)
    {
        // 使用微信支付SDK提供的算法
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));       // 设置APPID  读取配置文件
        $jsApiPayData->SetTimeStamp((string)time());        // 设置时间戳 转换为 string

        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);                  // 设置随机字符串

        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);   // 设置 prepay_id 注意格式
        $jsApiPayData->SetSignType('md5');                  // 设置加密类型

        $sign = $jsApiPayData->MakeSign();                  // 生成签名

        $rawValues = $jsApiPayData->GetValues();            // 转化为原始数据 存入所有参数
        $rawValues['paySign'] = $sign;                      // 将签名存入

        unset($rawValues['appId']);                         // 删除APPID 不传递出去

        return $rawValues;
    }

    private function recordPreOrder($wxOrder)
    {
        OrderModel::where('id','=',$this->orderID)
            ->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    // 验证方法
    private function checkOrderValid()
    {
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if (!$order)
        {  // 订单号不存在
            throw new OrderException();
        }

        if (!Token::isValidOperate($order->user_id)) {
            throw new TokenException([
                'msg' => '订单与用户不匹配' ,
                'errorCode' => 10003
            ]);
        }
        if ($order->status != OrderStatusEnum::UNPAID) {
            throw new OrderException([
                'msg' => '订单已经支付过' ,
                'errorCode' => 80003 ,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}