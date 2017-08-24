<?php
/**
 * Created by PhpStorm.
 * User: zuumau
 * Date: 2017/5/24
 * Time: 15:43
 */

namespace app\api\model;

//use app\api\model\Product as ProductModel;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from',
        'category_id', 'create_time', 'update_time'
    ];

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    public static function getProductByCategoryID($categoryID)
    {
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    public static function getProductDetail($id)
    {
        // $products = self::with(['imgs.imgUrl', 'properties'])->find($id);
        $products = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $products;
    }
}