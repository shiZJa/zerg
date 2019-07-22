<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/28
 * Time: 10:29
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
   //HTTP状态码
    public $code=400;

    //错误信息
    public $msg='参数错误';

    //自定义错误吗
    public $errorCode=10000;
}