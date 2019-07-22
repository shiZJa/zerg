<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/8
 * Time: 13:14
 */

namespace app\lib\exception;




class UserException extends BaseException
{
    //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='用户信息不存在';

    //自定义错误吗
    public $errorCode=60000;
}