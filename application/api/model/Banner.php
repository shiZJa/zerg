<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/26
 * Time: 15:11
 */

namespace app\api\model;

use think\Db;
use think\Model;

class Banner extends BaseModel
{
    protected  $hidden = ['update_time','delete_time'];
    static public function getBannerById($id)
    {
        $banner =  self::with(['items','items.img'])->find($id);
        return $banner;
    }
    public function items()
    {
        return $this->hasMany('bannerItem','banner_id','id');
    }
}