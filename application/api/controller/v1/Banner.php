<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/6/25
 * Time: 15:47
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IdMustBePositveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Controller;

class Banner extends BaseController
{
    /**获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id  banner的id号
     */

    public function getBanner($id){
        (new IdMustBePositveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);

        if(!$banner){
            throw new BannerMissException();
        }
        return json($banner,200);
    }
}