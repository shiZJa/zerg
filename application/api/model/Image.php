<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/3
 * Time: 11:16
 */

namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
    protected  $hidden = ['id','from','update_time','delete_time'];

    public function getUrlAttr($value,$data)
    {
        return parent::getImgPrefix($value,$data);
    }
}