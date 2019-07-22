<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/3
 * Time: 14:24
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected  $rule = [
        'ids'=>'require|checkIDs'
    ];
    protected  $message = [
        'ids'=>'ids参数必须是以逗号分割的正整数'
    ];
    protected  function checkIDs($value,$rule='',$data='',$field='')
    {
        $ids_arr = explode(',',$value);


        if(empty($ids_arr)){
            return false;
        }
        foreach($ids_arr as $id){

            if(!$this->isPostiveInteger($id)){
                return false;
            }
        }

        return true;
    }
}