<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/10
 * Time: 10:45
 */

namespace app\lib\exception;


class OrderException extends  BaseException
{
    //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='订单不存在，请检查ID';

    //自定义错误吗
    public $errorCode=80000;
}