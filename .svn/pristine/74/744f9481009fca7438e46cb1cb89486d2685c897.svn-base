<?php

namespace app\api\controller\mini;

use app\api\validate\AdviceValidate;
use app\api\validate\MarketValidate;
use app\api\validate\WechatValidate;
use app\service\controller\InterviewService;
use app\service\controller\MatterRecordService;
use app\service\controller\MarketService;
use app\service\controller\AdviceService;
use app\service\controller\UserService;
use app\service\controller\WechatService;
use think\App;

class Monitoring extends BaseFunction
{
    public $userId = '';

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->userId = input('post.user_id', '');
        if (!$this->userId) self::showReturnCode('', 1000, '参数有误');
        $this->MatterRecordService = new MatterRecordService();
        $this->MarketService       = new MarketService();
        $this->AdviceService       = new AdviceService();
        $this->UserService         = new UserService();
        $this->WechatService       = new WechatService();
        //验证员工与用户之间的关系
        //$this->checkRole();
    }

    /**
     * Notes: 验证员工是否有权限
     * User: myrxl
     * Date: 2019/10/15
     * Time: 15:37
     */
    public function checkRole()
    {
        $managerInfo = $this->UserService->getManager($this->userId);
        //用户id  $this->user;
        if (!in_array($this->user['gh'], $managerInfo) && ($this->user['id'] != $this->userId)) {
            self::showReturnCode('', 1500, '暂无权限');
        }
        return true;
    }


    /**
     * Notes:查看我在现场信息
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:12
     */
    public function getInterviewDetail()
    {
        $type    = input('post.type', '');
        $typeArr = ['morning_meeting', 'welcome', 'morning_tour', 'afternoon_tour', 'interview', 'send'];
        if (!$type || !in_array($type, $typeArr)) self::showReturnCode('', 1000, '参数有误');
        $res = (new InterviewService())->getDetail($this->date, $type, $this->userId);
        self::showReturnCode($res, 0, 'ok');
    }

    /**
     * Notes:获取事项记录详情
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:12
     */
    public function getMatterRecordDetail()
    {
        //根据日期 用户信息获取 详情
        $detail = $this->MatterRecordService->getJoinInfo($this->userId, $this->date);
        self::showReturnCode($detail, 0, 'ok');
    }


    /**
     * Notes:市调对标-获取列表
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:12
     */
    public function getMarketLists()
    {
        $page = getPage(input('post.'));
        $list = $this->MarketService->getPageLists($this->userId, $page);
        self::showReturnCode(['total' => $list->total(), 'list' => $list->items()], 0);
    }

    /**
     * Notes:市调对标-获取详情
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:12
     */
    public function getMarketDetail()
    {
        (new MarketValidate())->goCheck('detail');
        $data = $this->MarketService->getDetail($this->userId, $this->data['id']);
        self::showReturnCode($data, 0, 'ok');
    }

    /**
     * Notes:获取运营建议列表
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:28
     */
    public function getAdviceLists()
    {
        $page = getPage(input('post.'));
        $list = $this->AdviceService->getPageLists($this->userId, $page);
        self::showReturnCode(['total' => $list->total(), 'list' => $list->items()], 0);
    }

    /**
     * Notes:获取运营建议详情
     * User: myrxl
     * Date: 2019/10/14
     * Time: 17:28
     */
    public function getAdviceDetail()
    {
        (new AdviceValidate())->goCheck('detail');
        $data = $this->AdviceService->getDetail($this->userId, $this->data['id']);
        self::showReturnCode($data, 0, 'ok');
    }

//    public function getUserInfoByUserId()
//    {
//        $data         = input('post.');
//        $UserInfo     = $this->UserService->getUserInfoById($data['user_id']);
//        $session_info = $this->WechatService->getSessionInfoByOpenid($UserInfo['openid']);
//        $res          = [
//            'user_info'    => $UserInfo,
//            'session_info' => $session_info,
//        ];
//        return json(['msg' => 'ok', 'code' => 0, 'data' => $res]);
//    }
//
//    public function getUserStepNum()
//    {
//        (new WechatValidate())->goCheck('decryptData');
//        $data                = input('post.');
//        $data['session_key'] = $data['user_session_key'];
//        $res                 = $this->WechatService->decryptData($data);
//        if ($res['code'] == 0) {
//            return json(['msg' => 'ok', 'code' => 0, 'data' => $res['data']]);
//        } else {
//            return json(['msg' => '解密失败', 'code' => $res['code'], 'data' => '']);
//        }
//    }


}