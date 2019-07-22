<?php
return [
    'app_id'=>'wxf1052566324f5d5c',
    'app_secret'=>'50c8f470e8531c66c8b6949f5e1ecd14',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    'pay_back_url'=>'http://z.cn/api/v1/pay/notify',
];