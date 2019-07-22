<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/9
 * Time: 18:37
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Controller;

class BaseController extends Controller
{
    //用户和cms管理员都可以访问的权限
    protected function checkPrimaryScope(){
        TokenService::needPrimaryScope();

    }
    //用户可以访问的权限
    protected function checkExclusiveScope(){
        TokenService::needExclusiveScope();

    }
}