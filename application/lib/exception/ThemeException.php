<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/3
 * Time: 22:07
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
   //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='指定的主题不存在';

    //自定义错误吗
    public $errorCode=30000;
}