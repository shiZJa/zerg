<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    public function getImgPrefix($value,$data)
    {
        if($data['from'] == 1){
            return config('set.img_prefix').$value;
        }else{
            return $value;
        }
    }
}
