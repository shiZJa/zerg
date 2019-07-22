<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/10
 * Time: 13:54
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','update_time','delete_time'];
    protected $autoWriteTimestamp = true;
    public static function getSummaryByUser($uid, $page=1, $size=15)
    {
        $pagingData = self::where('user_id', '=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }
}