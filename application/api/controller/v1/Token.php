<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/5
 * Time: 16:23
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;
class Token
{
    public function getToken($code)
    {

        (new  TokenGet())->goCheck();
        $token = (new UserToken($code))->get();
        return ['token'=>$token];
    }

    public function verifyToken($token ='')
    {
        if(!$token){
            throw new ParameterException([
                'msg'=>'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid'=>$valid
        ];
    }

    /**
     * 第三方应用
     */
}