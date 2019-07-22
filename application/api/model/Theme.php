<?php

namespace app\api\model;

use think\Model;

class Theme extends BaseModel
{
    protected $hidden = ['head_img_id','topic_img_id','delete_time','update_time'];
    public function topicImage()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImage()
    {
        return $this->belongsTo('Image','head_img_id','id');
    }

    public  function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    static public function getThemeWithProducts($id)
    {
        $theme = self::with(['products','topicImage','headImage'])->find($id);
        return $theme;
    }
}
