<?php

namespace app\service\controller\web;

use app\model\Contract;
use app\service\controller\BaseService;
use app\service\controller\CleanAssessmentService;
use app\service\controller\CleanDetailService;
use app\service\controller\CleanItemService;
use app\service\controller\UserService;
use think\App;


class CleanService extends BaseService
{
    private $CleanItemService;
    private $CleanDetailService;
    private $CleanAssessmentService;
    private $UserService;
    private $ContractModel;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->CleanDetailService     = new CleanDetailService();
        $this->CleanAssessmentService = new CleanAssessmentService();
        $this->CleanItemService       = new CleanItemService();
        $this->UserService            = new UserService();
        $this->ContractModel          = new Contract();
    }

    /**
     * Notes:保洁卫生每日打分表
     * User: myrxl
     * @param $data
     * @return array
     * Date: 2020/10/19
     * Time: 13:45
     */
    public function dayReport($data)
    {
        /**
         * 通过门店信息 日期  获取每日打分
         * 1：获取所有一级类目
         * 1:获取主表信息
         * 2：获取详情表数据
         */

        $main    = $this->CleanAssessmentService->getStatusList($data['mall_id'], $data['date']);
        $typeArr = array_column($main, NULL, 'type');

        //获取提交人信息
        if (empty($main)) {
            $user = "未提交";
        } else {
            $userNameArr = $this->UserService->getUserNameList(array_column($main, 'user_id'));
            $user        = implode(",", array_column($userNameArr, 'name'));
        }

        //获取详情
        $detail = $this->CleanDetailService->getJoinList($main);

        //重新组装数据
        $detailArr = [];
        foreach ($detail as $kk => $vv) {
            $detailArr[$vv['first_id']]['name'] = $vv['first_name'];
            $detailArr[$vv['first_id']]['id']   = $vv['first_id'];
            $detailArr[$vv['first_id']]['type'] = $this->getString($vv['item_type']);

            if (1 == $vv['type']) {
                $detailArr[$vv['first_id']]['type1'][] = $vv['num'];
            } else {
                $detailArr[$vv['first_id']]['type2'][] = $vv['num'];
            }
        }

        $dataDetaile = [];

        if (1 == count($main)) {
            if (1 == $main[0]['type']) {
                //只有晨巡
                $type1Count = strval(array_sum(array_column($detail, "num")));
                $type2Count = "50";
                $type1      = $main[0]['pic'];
                $type2      = '-';
                $number1    = $main[0]['arrived_num'];
                $number2    = "-";
            } else {
                //只有午巡
                $type1Count = "50";
                $type2Count = strval(array_sum(array_column($detail, "num")));
                $type1      = '-';
                $type2      = $main[0]['pic'];
                $number1    = "-";
                $number2    = $main[0]['arrived_num'];

            }

            foreach ($detailArr as $k => $v) {
                $count         = $this->getNum($v['id']);
                $type1Detail   = isset($v['type1']) ? strval(array_sum($v['type1'])) : '-';
                $type2Detail   = isset($v['type2']) ? strval(array_sum($v['type2'])) : '-';
                $dataDetaile[] = ['id' => $v['id'], "name" => $v['name'], "count" => $count, "type" => $v['type'], "type1" => $type1Detail, "type2" => $type2Detail, "number" => "-", "user" => $user];
            }
            $arrNum    = count($dataDetaile);
            $dataCount = [
                ["id" => $arrNum + 1, "name" => "日均实到人数", "count" => array_sum(array_column($main, 'arrived_num')) / 2, "type" => "", "type1" => strval($number1), "type2" => strval($number2), "number" => array_sum(array_column($main, 'arrived_num')) / 2, "user" => $user],
                ["id" => $arrNum + 2, "name" => "保洁合影", "count" => "-", "type" => "", "type1" => $type1, "type2" => $type2, "number" => "-", "user" => $user],
                ["id" => $arrNum + 3, "name" => "扣分总计", "count" => "-" . ($type1Count + $type2Count), "type" => "", "type1" => "-" . $type1Count, "type2" => "-" . $type2Count, "number" => "-", "user" => $user],
            ];


        } else if (2 == count($main)) {

            foreach ($detailArr as $k => $v) {
                $count         = $this->getNum($v['id']);
                $dataDetaile[] = ['id' => $v['id'], "name" => $v['name'], "count" => $count, "type" => $v['type'], "type1" => strval(array_sum($v['type1'])), "type2" => strval(array_sum($v['type2'])), "number" => "-", "user" => $user];
            }
            $arrNum     = count($dataDetaile);
            $type1Count = array_sum(array_column($dataDetaile, 'type1'));
            $type2Count = array_sum(array_column($dataDetaile, 'type2'));
            $dataCount  = [
                ["id" => $arrNum + 1, "name" => "日均实到人数", "count" => array_sum(array_column($main, 'arrived_num')) / 2, "type" => "", "type1" => strval($typeArr['1']['arrived_num']), "type2" => strval($typeArr['2']['arrived_num']), "number" => array_sum(array_column($main, 'arrived_num')) / 2, "user" => $user],
                ["id" => $arrNum + 2, "name" => "保洁合影", "count" => "-", "type" => "", "type1" => $typeArr['1']['pic'], "type2" => $typeArr['2']['pic'], "number" => "-", "user" => $user],
                ["id" => $arrNum + 3, "name" => "扣分总计", "count" => "-" . ($type1Count + $type2Count), "type" => "", "type1" => "-" . $type1Count, "type2" => "-" . $type2Count, "number" => "-", "user" => $user],
            ];

        } else {

            //获取所有一级类目
            $item = $this->CleanItemService->getFirstList();
            foreach ($item as $k => $v) {
                $count           = $this->getNum($v['id']);
                $dataDetaile[$k] = ["id" => $k + 1, "name" => $v['name'], "count" => $count, "type" => $this->getString($v['type']), "type1" => "未到", "type2" => "未到", "number" => "-", "user" => $user];
            }
            $arrNum    = count($dataDetaile);
            $dataCount = [
                ["id" => $arrNum + 1, "name" => "日均实到人数", "count" => "-", "type" => "", "type1" => "-", "type2" => "-", "number" => "0", "user" => $user],
                ["id" => $arrNum + 2, "name" => "保洁合影", "count" => "-", "type" => "", "type1" => "-", "type2" => "-", "number" => "-", "user" => $user],
                ["id" => $arrNum + 3, "name" => "扣分总计", "count" => "-100", "type" => "", "type1" => "-50", "type2" => "-50", "number" => "-", "user" => $user],
            ];
        }

        $res = array_merge($dataDetaile, $dataCount);

        return $res;
    }


    /**
     * Notes:保洁月度统计表
     * User: myrxl
     * @param $mall_id
     * @param $date
     * @return array
     * Date: 2020/10/19
     * Time: 11:28
     */
    public function monthReport($mall_id, $date)
    {
        //关联查询
        $main = $this->CleanAssessmentService->getMonthList($mall_id, $date);
        $data = [];
        foreach ($main as $k => $v) {
            $data[$v['mall_id']]["mall_id"]                            = $v['mall_id'];
            $data[$v['mall_id']]["mall"]                               = $v['mall'];
            $data[$v['mall_id']]['list'][$v['first_id']]['first_id']   = $v['first_id'];
            $data[$v['mall_id']]['list'][$v['first_id']]['first_name'] = $v['first_name'];
            $data[$v['mall_id']]['list'][$v['first_id']]['child'][]    = $v;
        }
        $newData = [];
        foreach ($data as $kk => $vv) {
            $newData[$kk]['mall'] = $vv['mall'];
            foreach ($vv['list'] as $kkk => $vvv) {
                $newData[$kk]['list'][$kkk . 'num'] = array_sum(array_column($vvv['child'], "num"));
            }
        }
        $res = [];
        foreach ($newData as $k => $v) {
            $res[$k]['mall']  = $v['mall'];
            $res[$k]['count'] = array_sum(array_values($v['list']));
            foreach ($v['list'] as $kk => $vv) {
                $res[$k][$kk] = $vv;
            }
        }


        return array_values($res);
    }


    /**
     * Notes: 获取合同详情
     * User: myrxl
     * @param $param
     * @return array|bool
     * Date: 2020/10/19
     * Time: 17:32
     */
    public function getContractInfo($param)
    {
        $map = [
            "date"    => $param['date'],
            "mall_id" => $param['mall_id'],
        ];

        return $this->ContractModel->getBaseInfo("*", $map);
    }

    /**
     * Notes:保存合同信息
     * User: myrxl
     * @param $param
     * @return bool
     * Date: 2020/10/19
     * Time: 11:37
     */
    public function saveContractInfo($param)
    {
        //获取这个月服务天数：
        if ($param['week_day'] == "") {
            $week_day = 0;
        } else {
            $week_day = count(explode(",", $param['week_day']));
        }
        $num  = date("t", strtotime($param['date'])) - $week_day;
        $data = [
            "num"      => $num,
            "money"    => $param['money'],
            "week_day" => $param['week_day'],
            "mall_id"  => $param['mall_id'],
            "mall"     => $param['mall'],
            "date"     => $param['date'],
        ];


        $map = [
            "date"    => $param['date'],
            "mall_id" => $param['mall_id'],
        ];

        $res = $this->ContractModel->getBaseInfo("*", $map);
        if ($res) {
            return $this->ContractModel->baseSaveInfo($data, ['id' => $res['id']], 'edit');
        } else {
            return $this->ContractModel->addOne($data);
        }
    }

    /**
     * Notes:每月保洁质量评定表
     * User: myrxl
     * Date: 2020/10/20
     * Time: 8:53
     */
    public function monthCleanAssessmentReport($param)
    {

        //获取月初和月末时间
        $date  = currentMonth($param['date']);
        $start = $date['start'];
        $end   = $date['end'];

        //获取当前月份有多少天
        $day = date("t", strtotime($start));
        //获取当前是周几
        $weekArray = ["日", "一", "二", "三", "四", "五", "六"];


        //获取主表信息
        $main     = $this->CleanAssessmentService->getList($param['mall_id'], $start, $end);
        $mainData = [];
        foreach ($main as $kk => $vv) {
            $mainData[$vv['date'] . "," . $vv['type']] = $vv;
        }

        //获取详情表数据
        $detail     = $this->CleanDetailService->getGroupByList(array_column($main, "id"));
        $detailData = [];
        foreach ($detail as $k => $v) {
            $detailData[$v['date'] . "," . $v['type']] = $v;
        }
        //获取当月合同信息
        $map      = [
            "date"    => $param['date'],
            "mall_id" => $param['mall_id'],
        ];
        $contract = $this->ContractModel->getBaseInfo("*", $map);
        if (!$contract) {
            return false;
        }
        if ($contract['week_day'] != "") {
            $weekArr = explode(",", $contract['week_day']);
        } else {
            $weekArr = [];
        }
//        $weekArr     = explode(",", $contract['week_day']);
        $service_day = $day - count($weekArr);//本月服务天数
        $money       = $contract['money'];//本月合同总金额
        $num         = $contract['num'];//应到人数
        $day_money   = floor($contract['money'] / $service_day * 100) / 100;//每日服务费

        $data = [];
        for ($i = 1; $i <= $day; $i++) {
            if ($i < 10) {
                $i = "0" . $i;
            }
            $week             = "星期" . $weekArray[date("w", strtotime($param['date'] . "-" . $i))];
            $data[$i]['day']  = $i;
            $data[$i]['week'] = $week;

            if (in_array($i, $weekArr)) {
                $arrived_morning   = "0";
                $arrived_afternoon = "0";
                $num_morning       = "休息日";
                $num_afternoon     = "休息日";
                $average           = "0";
                $fee               = "0";
            } else {
                $arrived_morning   = isset($mainData[$param['date'] . "-" . $i . ",1"]["arrived_num"]) ? $mainData[$param['date'] . "-" . $i . ",1"]["arrived_num"] : "0";
                $arrived_afternoon = isset($mainData[$param['date'] . "-" . $i . ",2"]["arrived_num"]) ? $mainData[$param['date'] . "-" . $i . ",2"]["arrived_num"] : "0";
                $num_morning       = isset($detailData[$param['date'] . "-" . $i . ",1"]["num"]) ? $detailData[$param['date'] . "-" . $i . ",1"]["num"] : "50";
                $num_afternoon     = isset($detailData[$param['date'] . "-" . $i . ",2"]["num"]) ? $detailData[$param['date'] . "-" . $i . ",2"]["num"] : "50";
                $average           = ($num_morning + $num_afternoon) / 2;
                $fee               = $this->getFee($average);
            }

            $data[$i]['arrived_morning']   = $arrived_morning;
            $data[$i]['arrived_afternoon'] = $arrived_afternoon;
            $data[$i]['num_morning']       = $num_morning;
            $data[$i]['num_afternoon']     = $num_afternoon;
            $data[$i]['average']           = $average;
            $data[$i]['fee']               = ($fee * 100) . "%";
            $data[$i]['day_lock']          = ceil($day_money * $fee * 100) / 100;
        }
        $dataAll = array_values($data);

        $newData['day']               = "小计";
        $newData['week']              = "";
        $newData['arrived_morning']   = ceil(array_sum(array_column($dataAll, "arrived_morning")) / $service_day * 100) / 100;
        $newData['arrived_afternoon'] = ceil(array_sum(array_column($dataAll, "arrived_afternoon")) / $service_day * 100) / 100;
        $newData['num_morning']       = "";
        $newData['num_afternoon']     = "";
        $newData['average']           = "";
        $newData['fee']               = "";
//        $newData['day_lock']          = ceil(array_sum(array_column($dataAll, "day_lock")) / $service_day * 100) / 100;
        $newData['day_lock'] = ceil(array_sum(array_column($dataAll, "day_lock")) * 100) / 100;
        array_push($dataAll, $newData);

        foreach ($dataAll as $k => $v) {
            if (50 == $v['num_morning']) {
                $dataAll[$k]['num_morning'] = "未提交";
            }
            if (50 == $v['num_afternoon']) {
                $dataAll[$k]['num_afternoon'] = "未提交";
            }
        }


        $lock              = ceil(($contract['num'] - ($newData['arrived_morning'] + $newData['arrived_afternoon']) / 2) * 100) / 100;//月均缺岗人数
        $month_attend_rate = ceil(($newData['arrived_morning'] + $newData['arrived_afternoon']) / 2 / $contract['num'] * 100) . "%";//当月考勤率
        $day_unit          = floor($contract['money'] / $service_day / $contract['num'] * 100) / 100;//人均每日单价
        $dec_money1        = ceil($lock * $day_unit * 100) / 100;//保洁人员应扣小计
        $dec_money2        = ceil($newData['day_lock'] * 100) / 100;//保洁质量应扣小计
        $dec_money         = $dec_money1 + $dec_money2;//保洁合计扣款
        $money_all         = $money - $dec_money;//实际结算金额

        $collect = [
            "service_day"       => $service_day,
            "money"             => $money,
            "num"               => $num,
            "lock"              => $lock,
            "month_attend_rate" => $month_attend_rate,
            "day_unit"          => $day_unit,
            "day_money"         => $day_money,
            "dec_money1"        => $dec_money1,
            "dec_money2"        => $dec_money2,
            "dec_money"         => $dec_money,
            "money_all"         => $money_all,
        ];
        return ['list' => $dataAll, "main" => $collect];
    }


    private function getFee($num)
    {
        switch ($num) {
            case $num >= 0 && $num <= 10:
                $count = 0;
                break;
            case $num > 10 && $num <= 15:
                $count = 0.05;
                break;
            case $num > 15:
                $count = 0.1;
                break;
            default:
                $count = "0%";
        }
        return $count;
    }


    /**
     * Notes:获取每项总分
     * User: myrxl
     * @param $id
     * @return int
     * Date: 2020/10/15
     * Time: 11:57
     */
    private function getNum($id)
    {
        switch ($id) {
            case 1:
                $count = 12;
                break;
            case 2:
                $count = 22;
                break;
            case 3:
                $count = 14;
                break;
            case 4:
                $count = 10;
                break;
            case 5:
                $count = 18;
                break;
            case 6:
                $count = 24;
                break;
            default:
                $count = 12;
        }
        return $count;

    }

    /**
     * Notes: 获取单项扣分标准字符串
     * User: myrxl
     * @param $type
     * @return string
     * Date: 2020/10/20
     * Time: 14:19
     */
    private function getString($type)
    {
        if (1 == $type) {
            $string = "单项扣分可根据程度，选择-2分、-1分或不扣分三个选项";
        } else {
            $string = "单项扣分可根据程度，选择-1分、-0.5分或不扣分三个选项";
        }
        return $string;
    }

}
