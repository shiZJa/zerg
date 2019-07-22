<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/10
 * Time: 16:38
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IdMustBePositveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'getPreOrder'=>['only'=>'checkExclusiveScope']
    ];
    public function getPreOrder($id='')
    {
        (new IdMustBePositveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function redirectNotify()
    {
        //检查库存量
        //更新订单状态
        //减少库存
        //返回结果。true /false
//        -----------
//        post xml
        $notify = new WxNotify();
        //不能调用自己重写的NotifyProcess方法，此方法的参数是需要传递一个微信结果的data的，sdk有自己的入口方法dandle，
        //他会接受参数，自动去调用我们自己编写的回调方法
        $notify->handle();
    }
}