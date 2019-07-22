<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/8
 * Time: 10:29
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\api\Model\User as UserModel;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;


class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope'=>['only'=>'createOrUpdateAddress,getUserAddress']
    ];
    /**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    public function createOrUpdateAddress(){
        $addressValidate = new AddressNew();
        $addressValidate->goCheck();
        //根据token获取uid
        $uid = TokenService::getCurrentUid();
        //根据uid来查找用户信息,如果不存在抛出异常
        $user = UserModel::get($uid);

        if(!$user){
            throw new UserException();
        }

        $userData = $addressValidate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($userData);
        }else{
            $user->address->save($userData);
        }
        return json(new SuccessMessage(),201);
    }
}