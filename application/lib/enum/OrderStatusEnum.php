<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2019/7/11
 * Time: 9:39
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    //未支付
    const UNPAY = 1;

    //已支付
    const PATD = 2;

    //已发货
    const DELIVERED = 3;

    //已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}