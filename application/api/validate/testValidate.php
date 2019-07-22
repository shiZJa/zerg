<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/25
 * Time: 16:40
 */

namespace app\api\validate;


use think\Validate;

class testValidate extends Validate
{
    protected $rule = [
        'name'=>'require|max:10'
    ];
}