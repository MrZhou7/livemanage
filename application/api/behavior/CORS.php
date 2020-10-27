<?php
/**
 * copyright:http://www.thinkphp.cn/topic/59670.html @小丑鬼 10月21日
 */

namespace app\api\behavior;
use think\facade\Request;

class CORS
{
    public function appInit($params)
    {
        $origin       = Request::server('HTTP_ORIGIN') ?? '';
        $allow_origin = [
            'http://localhost:9528',
            'http://localhost:9528',
            'https://localhost:9528',
            'http://10.1.2.135:9529',
            'https://10.1.2.135:9529',
        ];
        if (in_array($origin, $allow_origin)) {
            header("Access-Control-Allow-Origin:{$origin}");
            header('Access-Control-Allow-Methods:*'); //支持的http 动作
            header('Access-Control-Allow-Credentials:true');//表示是否允许发送Cookie
            header('Access-Control-Max-Age: 3628800'); //支持的http 动作
            //header('Access-Control-Allow-Headers:Authorization, Content-Type, Accept, Origin, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With, X-Id, X-Token');  //响应头 请按照自己需求添加。
            header('Access-Control-Allow-Headers:x-requested-with,Content-Type,Authentication');  //响应头 请按照自己需求添加。
        }

        if (Request::isOptions()) {
            exit();
        }
    }
}
