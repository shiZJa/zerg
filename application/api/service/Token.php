<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/5
 * Time: 18:57
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{

    static  function needPrimaryScope(){
        $scope = self::getCurrentScope();
        if($scope){
            if($scope>=ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }

    }
    static function needExclusiveScope(){
        $scope = self::getCurrentScope();

        if($scope){
            if($scope==ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }

    }
    public static function generateToken(){
        $randChars = geRandChars(32);

        $timestamp = time();
        $salt = config('secure.token_salt');
        $randChars = md5($randChars.$timestamp.$salt);
        return $randChars;
    }

    public static function getCurrentTokenVar($type)
    {
        //获取令牌(token)=>key
        $token = Request::instance()->header('token');
        //获取用户信息=>value
        $value = Cache::get($token);

        if(!$value){
            throw new TokenException();
        }else{
            //如果是使用redis缓存，这里的值是数组，如果使用的是tp5的文件缓存，这里是字符串
            if(!is_array($value)){
                $value = json_decode($value,true);
            }
            if(array_key_exists($type,$value)){
                return $value[$type];
            }else{
                throw new Exception('尝试获取的token变量不存在');
            }

        }

    }

    public static function getCurrentUid(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function getCurrentScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        return $scope;
    }

    public static function isValidOperate($checkedUid){
        if(!$checkedUid){
            throw new Exception('需要检测的uid不能为空');
        }
        $uid = self::getCurrentUid();
        if($checkedUid == $uid){
            return true;
        }else{
            return false;
        }
    }

    public static function verifyToken($token)
    {
        $exist  = cache::get($token);
        if($exist){
            return true;
        }else{
            return false;
        }
    }
}