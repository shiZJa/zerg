<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/5
 * Time: 16:35
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WxException;
use think\Exception;
use app\api\model\User as UserModel ;
class UserToken extends Token
{
    protected $code;
    protected $app_id;
    protected $app_secret;
    protected $login_url;

    public function __construct($code)
    {
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->login_url = sprintf(config('wx.login_url'),$this->app_id,$this->app_secret, $this->code);

    }

    public function get()
    {
        $res = curl_get($this->login_url);
        $res = json_decode($res,true);
        if(empty($res)){
            throw new Exception('获取session_key异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$res);
            if($loginFail){
                $this->processLoginError($res);
            }else{
               return  $this->grantToken($res);
            }
        }

    }

    private function processLoginError($wxRes){

        throw new WxException([
            'msg'=>$wxRes['errmsg'],
            'errorCode'=>$wxRes['errcode']
        ]);

    }

    private function grantToken($wxRes){
        $openId = $wxRes['openid'];
        $user = UserModel::getByOpenID($openId);
        if(!$user){
            $uid = $this->newUser($openId);
        }else{
            $uid = $user->id;
        }

        $cachedValue = $this->cacheValue($wxRes,$uid);

        $token = $this->saveCache($cachedValue);
        return $token;
    }
    private function saveCache($cachedValue){
        $key  = self::generateToken();
        $value = json_encode($cachedValue);
        $token_expire_in = config('set.token_expire_in');
        $request = cache($key,$value,$token_expire_in);
        if(!$request){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }

        return $key;
    }


    private function newUser($openid){
       $user = UserModel::create([
           'openid'=>$openid
       ]);

        return $user->id;
    }

    private function cacheValue($wxRes,$uid){
        $cachedValue = $wxRes;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }
}