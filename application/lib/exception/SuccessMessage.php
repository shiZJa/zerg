<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/8
 * Time: 13:54
 */

namespace app\lib\exception;


class SuccessMessage
{
//HTTP状态码
    public $code=201;

    //错误信息
    public $msg='ok';

    //自定义错误吗
    public $errorCode=0;
}