<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/14
 * Time: 17:08
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\Token;
use app\api\service\Token as TokenService;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\enum\ScopeEnum;
use app\lib\exception\OrderException;
use app\lib\exceptionF\ForbiddenException;
use think\Controller;

class Order extends BaseController
{
    // 用户在选择商品后, 向API提交包含他所选择商品的相关信息
    // API在接受到信息后， 需要检查订单相关商品的库存量
    // 有库存，把订单数据存入数据库中 = 下单成功，返回客户端消息， 告诉客户端可以支付了
    // 调用我们的支付接口，进行支付
    // 还需要再次进行库存量检测
    // 服务器可以调用微信的支付接口进行支付
    // 小程序根据服务器返回的结果，拉起微信支付
    // 微信会返回给我们一个支付的结果
    // 成功：也需要再进行库存量的检查
    // 成功：进行库存量的扣除， 失败：返回支付失败的结果

    // 设置前置方法
    protected $beforeActionList = [
        // 当执行 second third 方法之前，都必须执行 first
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser']

    ];

    // 获取订单
    public function getSummaryByUser($page=1, $size=15)
    {
        (new PagingParameter())->goCheck();
        $uid = Token::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid, $page, $size);
        if ($pagingOrders->isEmpty()) {
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    public function getDetail($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail) {
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }


    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');   // 获取数组参数 /a
        $uid = TokenService::getCurrentUid();

        $order = new OrderService();
        $status = $order->place($uid, $products);
        return $status;
    }


}