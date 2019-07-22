<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:02
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected  $rule = [
        'count'=>'isPostiveInteger|between:1,15'
    ] ;

    protected $message = [

    ];
}