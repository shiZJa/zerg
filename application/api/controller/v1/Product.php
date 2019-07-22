<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:00
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IdMustBePositveInt;
use app\lib\exception\ProductException;

class Product extends BaseController
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $res = ProductModel::getRecent($count);
        if(!$res){
            throw new ProductException();
        }

        return $res;
    }

    public function getAllInCategory($id)
    {
        (new IdMustBePositveInt())->goCheck();
        $res = ProductModel::getProductByCategoryById($id);
        if(!$res){
            throw new ProductException();
        }
        return $res;
    }

    public function getOne($id)
    {
        (new IdMustBePositveInt())->goCheck();
        $res = ProductModel::getProductDetail($id);
        if(!$res){
            throw new ProductException();
        }
        return $res;
    }
}