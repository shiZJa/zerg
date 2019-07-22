<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/4
 * Time: 17:18
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    //HTTP状态码
    public $code=404;

    //错误信息
    public $msg='请求的product不存在,请检查商品参数';

    //自定义错误吗
    public $errorCode=20000;
}