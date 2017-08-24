<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/30
 * Time: 10:14
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;

use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductException;
        }
        $products = $products->hidden(['summary']);  // 隐藏 'summary'
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if ($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductDetail($id);
        if (!$products) {
            throw new ProductException();
        }
        return $products;
    }
}