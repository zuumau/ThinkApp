<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/6/18
 * Time: 15:33
 */

namespace app\api\controller;

use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    protected function checkExclusiveScope()
    {
        TokenService::needExclusiveScope();
    }
}