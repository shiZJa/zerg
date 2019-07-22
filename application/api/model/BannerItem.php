<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/3
 * Time: 10:52
 */

namespace app\api\model;


use think\Model;

class BannerItem extends BaseModel
{
    protected  $hidden = ['id','img_id','banner_id','delete_time'];
    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }
}