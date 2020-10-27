<?php

namespace app\api\controller\web;

use app\service\controller\web\CleanService;
use think\App;

/**
 * 评定项
 * Class Column
 * @package app\api\controller\web
 */
class Evaluation extends BaseController
{
    private $CleanService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->CleanService = new CleanService();
    }


    public function day()
    {
        return view();
    }

    /**
     * Notes: 保洁卫生每日打分表
     * User: myrxl
     * Date: 2020/10/15
     * Time: 9:17
     */
    public function dayReport()
    {
        $arr = input();
        if (empty($arr['mall_id']) || empty($arr['date'])) {
            self::showReturnCode([], 1001, "参数有误");
        }
        $res = $this->CleanService->dayReport($arr);
        self::showReturnCode($res, 0);
    }

    public function month()
    {
        return view();
    }

    /**
     * Notes: 保洁卫生每月打分表
     * User: myrxl
     * Date: 2020/10/15
     * Time: 9:17
     */
    public function monthReport()
    {
        $arr = input();
        if (empty($arr['mall_id']) || empty($arr['date'])) {
            self::showReturnCode([], 1001, "参数有误");
        }
        $res = $this->CleanService->monthReport(explode(",", $arr["mall_id"]), $arr['date']);
        self::showReturnCode($res, 0);
    }

    public function monthCleanAssessment()
    {
        return view();
    }

    /**
     * Notes: 保洁卫生每月质量评定表
     * User: myrxl
     * Date: 2020/10/15
     * Time: 9:17
     */
    public function monthCleanAssessmentReport()
    {
        $arr = input();
//        if (empty($arr['mall_id']) || empty($arr['date'])) {
//            self::showReturnCode([], 1001, "参数有误");
//        }
        $data = [
            'mall_id' => "9",
            'date'    => "2020-10",
        ];
        $res  = $this->CleanService->monthCleanAssessmentReport($arr);
        if ($res == false) {
            self::showReturnCode('', 1001, "请先设置合同信息");
        } else {
            self::showReturnCode($res, 0);
        }

    }

    /**
     * Notes:获取合同标准
     * User: myrxl
     * Date: 2020/10/19
     * Time: 17:31
     */
    public function getContractInfo()
    {
        $arr = input();
        if (empty($arr['mall_id']) || empty($arr['date'])) {
            self::showReturnCode([], 1001, "参数有误");
        }
        $res = $this->CleanService->getContractInfo($arr);
        self::showReturnCode($res, 0);
    }

    /**
     * Notes:保存合同标准
     * User: myrxl
     * Date: 2020/10/19
     * Time: 11:02
     */
    public function saveContractInfo()
    {
        $arr = input();
        if ($arr['week_day'] != ""){
            $week_day = explode(",", $arr['week_day']);
            if (count($week_day) != count(array_unique($week_day))) {
                self::showReturnCode([], 1001, "无需服务日期不能重复");
            }
            foreach ($week_day as $k => $v) {
                if (!is_numeric($v)) {
                    self::showReturnCode([], 1001, "请填写正确数字" . $v);
                }
                if (!($v >= 1 && $v <= 31)) {
                    self::showReturnCode([], 1001, "请填写正确的日期区间" . $v);
                }
            }
        }

        $res = $this->CleanService->saveContractInfo($arr);
        self::showReturnCode($res, 0);
    }


}
