<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/6
 * Time: 9:24
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','delete_time','product_id'];
    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}