<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/9
 * Time: 14:57
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    //HTTP状态码
    public $code=403;

    //错误信息
    public $msg='权限不够';

    //自定义错误吗
    public $errorCode=10001;
}