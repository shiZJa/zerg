<?php
return [
    'app_id'=>'',
    'app_secret'=>'',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    'pay_back_url'=>'https://zerg.bug3.cn/api/v1/pay/notify',
];
