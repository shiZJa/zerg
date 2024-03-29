<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/25
 * Time: 17:25
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\image\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        //获取所有的参数
        //对参数做校验

        $request =  Request::instance();
        $params = $request->param();
        $res = $this->batch()->check($params);
        if(!$res){
            $e = new ParameterException([
                'msg'=>$this->getError(),
            ]);
            throw $e;
        }else{
            return true;
        }
    }


    protected function isNotEmpty($value,$rule='',$data='',$field=''){
        if(!empty($value)){
            return true;
        }else{
            return false;
        }
    }

    protected function isPostiveInteger($value,$rule='',$data='',$field='')
    {
        //$value=>当前要验证的字段的值，$data=>要验证的数组，$field=>当前要验证的字段
        //因为$value传进来是字符串，所以加0转成数值
        if(is_numeric($value) && is_int($value+0) && ($value+0)>0){
            return true;
        }else{
            return false;
        }
    }

    public function getDataByRule($arrays){
        if(array_key_exists('uid',$arrays) || array_key_exists('user_id',$arrays)){
            throw new ParameterException([
                'msg'=>'参数中包含非法参数名user_id或uid'
            ]);
        }else{
            $newArray = [];
            foreach($this->rule as $key => $value){
                $newArray[$key] = $arrays[$key];
            }
            return $newArray;
        }


    }


    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}