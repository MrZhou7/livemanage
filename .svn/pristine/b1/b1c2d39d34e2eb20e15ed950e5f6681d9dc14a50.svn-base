<?php
namespace app\api\controller\mini;

use app\service\controller\UserService;
use think\App;

class BaseFunction extends BaseController
{
    protected $user;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        //查询用户信息
//        if (!Session($this->openid)) {
//            $userInfo = (new UserService())->getUserInfo($this->openid);
//            is_array($userInfo) ? Session($this->openid, $userInfo) : self::showReturnCode('', 1001, '用户信息不存在');
//        } else {
//            $userInfo = Session($this->openid);
//        }
//        $this->user = $userInfo;
        $userInfo = (new UserService())->getUserInfo($this->openid);
        if(is_array($userInfo)){
            $this->user = $userInfo;
        }else{
            self::showReturnCode('', 9999, '用户信息不存在');
        }
    }
}