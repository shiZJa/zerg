<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/27
 * Time: 21:24
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP状态码
    public $code=400;

    //错误信息
    public $msg='参数错误';

    //自定义错误吗
    public $errorCode=10000;

    public function __construct($param=[])
    {

        if(!is_array($param)){
            return;
        }

        if(array_key_exists('code',$param)){
            $this->code = $param['code'];
        }

        if(array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }

        if(array_key_exists('errorCode',$param)){
            $this->errorCode = $param['errorCode'];
        }
    }
}