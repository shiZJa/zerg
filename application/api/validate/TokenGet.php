<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/5
 * Time: 16:24
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected  $rule = [
        'code'=>'require|isNotEmpty'
    ] ;

    protected $message = [
        'code'=>'没有code,不能获取token'
    ];
}