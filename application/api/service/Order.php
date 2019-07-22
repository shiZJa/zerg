<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/9
 * Time: 19:20
 */

namespace app\api\service;


use app\api\model\Product as ProductModel;
use app\api\model\UserAddress as UserAddressModel;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use app\api\model\Order as OrderModel;
use app\api\model\OrderProduct as OrderProductModel;
use think\Db;
use think\Exception;

class Order
{
    //客户端传过来的
    protected  $oProducts;

    //数据库查出来的
    protected $products ;

    //uid
    protected $uid;

    //检查库存，失败，返回信息。成功，创建订单
    public function place($uid,$oProducts)
    {

        //对比两个数组
        //1.查出products
        $this->oProducts = $oProducts;
        $this->products = $this->getOProductsByProduct($oProducts);
        $this->uid =$uid;

        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }

        //开始创建订单
        $snap = $this->snapOrder($status);
        $order = $this->createOrder($snap);
        $order['pass'] = true;
        return $order;
    }

    private function createOrder($snap){
        Db::startTrans();
        try{
            $order_no = $this->createOrderNo();
            $orderModel = new OrderModel();
            $orderModel->user_id = $this->uid;
            $orderModel->order_no = $order_no;
            $orderModel->total_price = $snap['orderPrice'];
            $orderModel->snap_img = $snap['snapImg'];
            $orderModel->snap_address = $snap['snapAddress'];
            $orderModel->snap_items = json_encode($snap['pStatus']);
            $orderModel->snap_name = $snap['snapName'];
            $orderModel->total_count = $snap['totalCount'];

            $orderModel->save();

            //更新关联表
            $orderID = $orderModel->id;
            $oProducts = $this->oProducts;
            $create_time = $orderModel->create_time;
            foreach($oProducts as &$oProduct){
                $oProduct['order_id'] = $orderID;
            }

            $OrderProductModel = new OrderProductModel();
            $OrderProductModel->saveAll($oProducts);//保存一组数据saveAll
            Db::commit();
            return [
                'order_no'=>$order_no,
                'order_id'=>$orderID,
                'create_time'=>$create_time
            ];

        }catch(Exception $e){
            Db::rollback();
            throw $e;
        }
    }

    public function createOrderNo()
    {
        do{
            $order_sn = time().rand(100,999);
            $is_exist = OrderModel::where(['order_no'=>$order_sn])->find();
        }while($is_exist);

        return $order_sn;
    }
    //开始创建订单快照
    private function snapOrder($status){
        $snap = [
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatus'=>[],
            'snapAddress'=>null,
            'snapName'=>'',
            'snapImg'=>''
        ] ;

        $snap['totalCount'] = $status['totalCount'];
        $snap['orderPrice'] = $status['orderPrice'];
        $snap['pStatus'] = $status['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress());
        $snap['snapName'] = $this->products[0]['name'];
        $snap['snapImg'] = $this->products[0]['main_img_url'];

        if(count($this->products)>1){
            $snap['snapName'] .=$snap['snapName'].'等';
        }

        return $snap;
    }

    private function getUserAddress(){
        $address = UserAddressModel::where(['user_id'=>$this->uid])->find();
        if(!$address){
            throw new UserException([
                'msg'=>'收货地址不存在',
                'errorCode'=>'60001'
            ]);
        }
        return $address->toArray();
    }

    //根据订单商品列表数据查找$products
    private function getOProductsByProduct($oProducts)
    {

        $oPIDs = [];
        foreach($oProducts as $item){
            array_push($oPIDs,$item['product_id']);
        }

        $products = ProductModel::all($oPIDs)
            ->visible(['id','price','stock','name','main_img_url'])
            ->toArray();
        //因为设置了返回格式是json,这里要用到数组
        return $products;
    }

    //获取订单状态，返回$status
    private function getOrderStatus(){
        $status = [
            'pass'=>true,
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatusArray'=>[]
        ];
        foreach($this->oProducts as $oProduct){
            $pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
            if(!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['counts'];
            array_push($status['pStatusArray'],$pStatus);

        }
        return $status;
    }

    //每一个产品的状态
    //param(订单下单个商品的id,数量，数据库查出来订单下的所有商品信息)
    private function getProductStatus($oPID,$oCount,$products){
        //订单下某一个商品的详细信息
        $pStatus = [
            'id'=>null,
            'haveStock'=>false,
            'counts'=>0,//订单数量
            'name'=>'',
            'price'=>0,
            'main_img_url'=>'',
            'totalPrice'=>0
        ];
        $pIndex = -1;//当前商品在Products里的序号
        for($i = 0; $i<count($products); $i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }

        if($pIndex == -1){
            throw new OrderException([
                'msg'=>'id为'.$oPID.'的商品不存在，创建订单失败'
            ]);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['counts'] = $oCount;
            $pStatus['price'] = $product['price'];
            $pStatus['main_img_url'] = $product['main_img_url'];
            $pStatus['totalPrice'] = $oCount*$product['price'];
            $pStatus['haveStock'] = ($product['stock']-$oCount >= 0) ? true : false;
            return $pStatus;
        }
    }

    public function checkOrderStock($order_id){
        $oProducts = OrderProductModel::where(['order_id'=>$order_id])->select();
        $this->oProducts = $oProducts;
        $products = $this->getOProductsByProduct($oProducts);
        $this->products = $products;
        $status = $this->getOrderStatus();
        return $status;

    }
}