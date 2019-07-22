<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:29
 */

namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category extends BaseController
{
    public function getAllCategory()
    {
        $res = CategoryModel::all([],'img');
        if(!$res){
            throw new CategoryException();
        }
        return $res;
    }
}