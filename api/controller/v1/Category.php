<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 14:51
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\api\service\Token as TokenService;
use app\lib\exception\CategoryException;

class Category
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'getAllCategories']
    ];

    protected function checkPrimaryScope()
    {
        TokenService::needPrimaryScope();
    }

    public function getAllCategories()
    {
        $categories = CategoryModel::all([],'img');
        if ($categories->isEmpty()) {
            throw new CategoryException;
        }
        return $categories;
    }
}