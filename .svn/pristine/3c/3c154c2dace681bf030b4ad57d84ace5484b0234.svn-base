<?php

namespace app\api\controller\mini;

use app\service\controller\InterviewService;
use app\service\controller\CenterService;
use app\api\validate\MorningMeetingValidate;
use app\api\validate\WelcomeValidate;
use app\api\validate\MorningTourValidate;
use app\api\validate\AfternoonTourValidate;
use app\api\validate\InterviewValidate;
use app\api\validate\SendValidate;
use think\App;

class Interview extends BaseFunction
{
    public $centerid;

//    public $data;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->centerid      = $this->checkCenterIsSet();
        $this->CenterService = new CenterService();
//        $data           = input('post.');
//        unset($data['session_key']);
//        $this->data = $data;
    }

    /**
     * Notes: 检查用户今天是否操作过当前功能
     * User: myrxl
     * Date: 2019/8/21
     * Time: 9:33
     */
    public function checkCenterIsSet()
    {
        return (new InterviewService())->checkCenterIsSet($this->user);
    }


    public function checkValidate($type)
    {
        $typeArr = ['morning_meeting', 'welcome', 'morning_tour', 'afternoon_tour', 'interview', 'send'];
        if (!$type || !in_array($type, $typeArr)) self::showReturnCode('', 1000, 'type参数有误');
        if ($type == 'morning_tour' || $type == 'afternoon_tour') {
            $arrPic = objectToArray(json_decode($this->data['pic']));
            foreach ($arrPic as $k => $v) {
                $problem[] = $v['explain'] ? $v['explain'] : '';
                $pic[]     = $v['pic'] ? $v['pic'] : '';
            }

            if (count($pic) != count($problem)) self::showReturnCode('', 1000, '请将问题图片与问题描述对应');
            $this->data['pic']     = implode('{|}', $pic);
            $this->data['problem'] = implode('{|}', $problem);
        }

        switch ($type) {
            case "morning_meeting":
                $Validate = (new MorningMeetingValidate());
                break;
            case "welcome":
                $Validate = (new WelcomeValidate());
                break;
            case "morning_tour":
                $Validate = (new MorningTourValidate());
                break;
            case "afternoon_tour":
                $Validate = (new AfternoonTourValidate());
                break;
            case "interview":
                $Validate = (new InterviewValidate());
                break;
            case "send":
                $Validate = (new SendValidate());
                break;
        }
        $Validate->goCheck();
    }

    /**
     * Notes:添加我在现场接口（晨会，迎宾，晨巡，午巡，商户访谈，送宾）
     * User: myrxl
     * Date: 2019/8/21
     * Time: 8:59
     */
    public function addInterview()
    {
        $type = input('post.type', '');
        $this->checkValidate($type);
        unset($this->data['type']);
        $centerInfo = $this->CenterService->getCenterInfo($this->user['id'], date('Y-m-d', time()));
        if ($centerInfo['is_' . $type] == 1) self::showReturnCode('', 1001, '请勿重复添加信息');

        $checkTime = true;
        //“晨巡”填写、提交操作时间限制于每天9：30-12：00
        if ('morning_tour' === $type) {
            $start = '09:30';
            $end   = '12:00';
            $checkTime = checkIsBetweenTime($start, $end);
        }
        //“午巡”填写、提交时间限制于每天13：30-17：00
        if ('afternoon_tour' === $type) {
            $start = '13:30';
            $end   = '17:00';
            $checkTime = checkIsBetweenTime($start, $end);
        }
        if (!$checkTime) {
            self::showReturnCode('', 1002, '请在正确的时间进行提交');
        }

        $res = (new InterviewService($this->centerid))->addInterview($this->data, $type);
        if ($res) {
            self::showReturnCode('', 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }


    /**
     * Notes:查看我在现场信息
     * User: myrxl
     * Date: 2019/8/21
     * Time: 8:59
     */
    public function getDetail()
    {
        //$date    = input('post.date', date('Y-m-d'));
        $type    = input('post.type', '');
        $typeArr = ['morning_meeting', 'welcome', 'morning_tour', 'afternoon_tour', 'interview', 'send'];
        if (!$type || !in_array($type, $typeArr)) self::showReturnCode('', 1000, '参数有误');
        $res = (new InterviewService())->getDetail($this->date, $type, $this->user['id']);
        if ($res) {
            self::showReturnCode($res, 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '查询失败');
        }
    }

    /**
     * Notes: 修改我在现场的信息 （只能修改当天的）
     * User: myrxl
     * Date: 2019/8/22
     * Time: 13:54
     */
    public function updateInterview()
    {
        $type = input('post.type', '');
        $id   = input('post.id', '');
        if (!$id) self::showReturnCode('', 1000, '缺少id参数');
        $this->checkValidate($type);
        unset($this->data['type']);
        $res = (new InterviewService())->updateInterview($this->data, $type, $this->user['id']);
        if ($res === 'NOTTODAY') self::showReturnCode('', 1001, '只能修改当天的数据');
        if ($res) {
            self::showReturnCode($res, 0, '保存成功');
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }

}