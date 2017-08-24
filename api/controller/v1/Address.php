<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/7
 * Time: 17:46
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\Controller;

class Address extends BaseController
{
    // 设置前置方法
    protected $beforeActionList = [
        // 当执行 second third 方法之前，都必须执行 first
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    // 需要前置方法
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        //(new AddressNew())->goCheck();
        // 根据 Token 来获取uid
        // 根据uid来查找用户数据， 判断用户是否存在， 如果不存在则抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在，从而判断是添加地址还是更新地址

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;

        if (!$userAddress) {
            $user->address()->save($dataArray);   // 新增
        }
        else {
            $user->address->save($dataArray);   // 更新
        }

        return json(new SuccessMessage(),201);
    }
}
