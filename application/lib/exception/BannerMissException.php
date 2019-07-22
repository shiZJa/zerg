<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/27
 * Time: 21:26
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='请求的banner不存在';

    //自定义错误吗
    public $errorCode=40000;
}