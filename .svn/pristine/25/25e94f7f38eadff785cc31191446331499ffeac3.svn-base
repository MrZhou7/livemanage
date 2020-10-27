<?php

namespace app\service\controller;

use app\model\WechatSessionkey;
use lib\xcx\crypt\wxBizDataCrypt;
use think\App;
use think\facade\Env;

class WechatService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->appid  = Env::get('weChat.appid');
        $this->secret = Env::get('weChat.secret');
    }

    /**
     * Notes:登录凭证校验
     * User: myrxl
     * Date: 2019/8/19
     * Time: 15:06
     * @param $arr
     * @return bool|string
     */
    public function jscode2session($arr)
    {
        //$url    = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->appid}&secret={$this->secret}&js_code=011y5f5b0Aou3y1uoB4b0OY55b0y5f57&grant_type=authorization_code";
        $url    = "https://api.weixin.qq.com/sns/jscode2session?appid={$this->appid}&secret={$this->secret}&js_code={$arr['js_code']}&grant_type=authorization_code";
        $res    = httpGet($url);
        $Object = json_decode($res);
        if (isset($Object->session_key)) {
            $appSession = MD5('AYD-' . MD5($Object->session_key));
            $data       = [
                'openid'      => $Object->openid,
                'session_key' => $Object->session_key,
                'app_session' => $appSession,
                'js_code'     => $arr['js_code'],
                'unionid'     => isset($Object->unionid) ? $Object->unionid : '',
            ];
            //把用户openid+session_key  存入数据库中
            (new WechatSessionkey())->updateWechatEnable($data['openid']);
            (new WechatSessionkey())->addWechatSessionKey($data);
            $Object->code        = 0;
            $Object->msg         = 'ok';
            $Object->session_key = $appSession;
        } else {
            $Object->code = $Object->errcode;
            $Object->msg  = $Object->errmsg;
            unset($Object->errcode);
            unset($Object->errmsg);
        }
        return json_encode($Object);

    }

    /**
     * Notes:通过sessionkey 获取 openid
     * User: myrxl
     * Date: 2019/8/19
     * Time: 20:08
     */
    public function getSessionInfo($session_key)
    {
        return (new WechatSessionkey())->getSessionInfo($session_key);
    }

    public function getSessionInfoByOpenid($openid)
    {
        return (new WechatSessionkey())->getSessionInfoByOpenid($openid);
    }

    public function decryptData($arr)
    {
        $appid         = $this->appid;
        $encryptedData = $arr['encryptedData'];
        $iv            = $arr['iv'];
        $session       = $this->getSessionInfo($arr['session_key']);
        $pc            = new WXBizDataCrypt($appid, $session['session_key']);
        $errCode       = $pc->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            return ['code' => 0, 'data' => $data];
        } else {
            return ['code' => $errCode];
        }
    }
}
