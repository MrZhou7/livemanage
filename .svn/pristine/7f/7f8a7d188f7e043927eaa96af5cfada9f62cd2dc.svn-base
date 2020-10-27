<?php
namespace app\api\controller\mini;
use app\api\validate\WechatValidate;
use app\service\controller\WechatService;
use think\App;
use think\Controller;
class Wechat extends Controller
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->WechatService = new WechatService();
    }

    /**
     * 文档地址：https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html
     * 参数：appid  secret js_code grant_type
     * 返回：session_key
     */
    public function jscode2session()
    {
        (new WechatValidate())->goCheck('getSessionKey');
        return $this->WechatService->jscode2session(input());
    }

    /**
     * Notes:解密微信数据
     * User: myrxl
     * Date: 2019/8/21
     * Time: 17:15
     * @return \think\response\Json
     * @throws \app\lib\exception\ParameterException
     */
    public function decryptData()
    {
        (new WechatValidate())->goCheck('decryptData');
        $res = $this->WechatService->decryptData(input('post.'));
        if ($res['code'] == 0) {
            return json(['msg' => 'ok', 'code' => 0, 'data' => $res['data']]);
        } else {
            return json(['msg' => '解密失败', 'code' => $res['code'], 'data' => '']);
        }
    }
}