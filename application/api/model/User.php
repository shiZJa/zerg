<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/5
 * Time: 16:33
 */

namespace app\api\model;


class  User extends BaseModel
{
    public  function address()
    {
        return $this->hasOne('UserAddress','user_id','id');
    }

    public static function getByOpenID($openid)
    {
        $user = self::where(['openid'=>$openid])->find();
        return $user;
    }


}