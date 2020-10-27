<?php
namespace app\model;

class WechatSessionkey extends BaseModel
{
    public function addWechatSessionKey($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function updateWechatEnable($openid)
    {
        return $this->baseSaveInfo(['enabled' => 0], ['openid' => $openid], 'edit');
    }

    public function getSessionInfo($session_key)
    {
        return $this->getBaseInfo('openid,session_key', ['app_session' => $session_key, 'enabled' => 1], 'id desc');
    }

    public function getSessionInfoByOpenid($openid)
    {
        return $this->getBaseInfo('openid,session_key,app_session', ['openid' => $openid, 'enabled' => 1], 'id desc');
    }
}