<?php
return [
    'gaode'=>[
        'url'=>'https://restapi.amap.com/v3/geocode/geo?key=39cdd0ec0a8bb7a52f8c56334cb76755&address=%s'
    ],
    'wechat'=>[
        'appid'=>'wx4f10e4ecf3a68ce3',
        'secret'=>'3b4735c81a599ae4b416a88b82132fa8',
        'url'=>'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code'
    ]
];