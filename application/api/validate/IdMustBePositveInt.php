<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/25
 * Time: 16:57
 */

namespace app\api\validate;

class IdMustBePositveInt extends BaseValidate
{

    //我的理解：
    //1.在这里定义验证规则呢，在banner控制器实例化此类的时候，就已经初始化到Validate基类里面的$rule,
    //2.字类可以使用父类的方法，在BaseValidate里面获取参数，并且调用Validate的check方法，就会把rule使用到里面，
    //并且进行校验返回错误信息

    protected $rule = [
        'id'=>'require|isPostiveInteger'
    ];
    protected  $message = [
        'id'=>'id必须是正整数'
    ];
//    protected function isPostiveInteger($value,$rule='',$data='',$field='')
//    {
//        //$value=>当前要验证的字段的值，$data=>要验证的数组，$field=>当前要验证的字段
//        //因为$value传进来是字符串，所以加0转成数值
//        if(is_numeric($value) && is_int($value+0) && ($value+0)>0){
//            return true;
//        }else{
//            return $field.'必须是正整数';
//        }
//    }
}