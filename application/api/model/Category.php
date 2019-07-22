<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:30
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected  $hidden = ['create_time','update_time','delete_time'];

    public function img(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}