<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:35
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='请求的category不存在';

    //自定义错误吗
    public $errorCode=50000;
}