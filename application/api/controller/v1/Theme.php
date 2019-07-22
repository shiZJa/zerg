<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDCollection;
use app\api\validate\IdMustBePositveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\model\Theme as ThemeModel;
class Theme extends BaseController
{
    /**
     * @url /theme?ids=id1,id2,id3.....
     * @return 一组theme模型
     */
    public function getSimpleList($ids)
    {
        (new IDCollection())->goCheck();
        $ids_arr = explode(',',$ids);
        $res = ThemeModel::with('topicImage,headImage')->select($ids);
        if(!$res){
            throw new ThemeException();
        }
        return $res;
    }

    /**
     * @url /theme/:id
     * @param $id
     * @throws \app\lib\exception\ParameterException
     */
    public function getComplexOne($id)
    {
        (new IdMustBePositveInt())->goCheck();
        $res = ThemeModel::getThemeWithProducts($id);
        if(!$res){
            throw new ThemeException();
        }
        return $res;
    }
}
