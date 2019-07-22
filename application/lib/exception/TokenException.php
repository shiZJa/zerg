<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/6
 * Time: 0:29
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    //HTTP状态码
    public $code=401;

    //错误信息
    public $msg='Token无效或过期';

    //自定义错误吗
    public $errorCode=10001;
}