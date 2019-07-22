<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/27
 * Time: 20:14
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //需要返回客户端当前的请求路径
    public function render(\Exception $ex){
        if($ex instanceof BaseException){
            //如果是自定义的异常
            $this->code = $ex->code;
            $this->msg = $ex->msg;
            $this->errorCode = $ex->errorCode;

        }else{
            if(config('app_debug')){
                return parent::render($ex);
                //如果是开发模式，是需要知道报错的具体信息的，所以要用tp5默认的异常处理页面来显示，也就是
                //tp5自己的已成处理类
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($ex);
            }

        }
        $request = Request::instance();
        $result = [
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>$request->url()
        ];


        return json($result,$this->code);
    }


    private function recordErrorLog(Exception $e)
    {
        Log::record($e->getMessage(),'error');
    }

}