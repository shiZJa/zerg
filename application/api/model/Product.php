<?php

namespace app\api\model;

use think\Model;

class Product extends BaseModel
{
    protected $hidden = ['pivot','create_time','update_time','delete_time'];

    public function getMainImgUrlAttr($value,$data)
    {
        return parent::getImgPrefix($value,$data);
    }

    static public function getRecent($count)
    {
        $product = self::limit($count)->order('create_time desc')->select();
        return $product;
    }

    static public function getProductByCategoryById($c_id){
        $product = self::where(['category_id'=>$c_id])->select();
        return $product;
    }

    static function getProductDetail($id){

          return  self::with(['properties'])
                  ->with([
                      'imgs'=>function($query){
                          $query->with('imgUrl')->order('order','asc');
                      }
                  ])
                  ->find($id);
    }


    public function imgs(){

       return  $this->hasMany('ProductImage','product_id','id');
    }
    //关联商品属性
    public function properties(){

        return $this->hasMany('ProductProperty','product_id','id');
    }
}
