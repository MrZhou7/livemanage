<?php

namespace app\api\controller\mini;

use app\api\validate\CleanAssessmentValidate;
use app\service\controller\CleanAssessmentService;
use app\service\controller\CleanDetailService;
use app\service\controller\CleanItemService;
use think\App;
use think\Db;

/**
 * 评定项
 * Class Column
 * @package app\api\controller\web
 */
class Evaluation extends BaseFunction
{
    private $CleanAssessmentService;
    private $CleanDetailService;
    private $CleanItemService;

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->CleanAssessmentService = new CleanAssessmentService();
        $this->CleanDetailService     = new CleanDetailService();
        $this->CleanItemService       = new CleanItemService();
    }

    /**
     * Notes: 获取评定项参数
     * User: myrxl
     * Date: 2020/10/13
     * Time: 9:52
     */
    public function getCleanItemList()
    {

        $res  = $this->CleanItemService->getCleanItemList();
        $data = toLayer($res);
        self::showReturnCode($data, 0);

    }

    /**
     * Notes:添加评定项
     * User: myrxl
     * Date: 2020/10/12
     * Time: 9:20
     */
    public function add()
    {
        (new CleanAssessmentValidate())->goCheck('add');
        Db::startTrans();
        try {
            //校验填写权限
//            $this->checkAddClean();

            //获取拼接后的数据（主表和详情表）
            $res_data = $this->getAddData();

            //新增主表信息
            $res_main = $this->CleanAssessmentService->add($res_data['main']);
            if ($res_main < 0) {
                Db::rollback();
                exception('数据重复，请勿重复添加', 1001);
            }
            //新增详情表数据
            foreach ($res_data['detail'] as $d => $a) {
                $res_data['detail'][$d]['assessment_id'] = $res_main;
            }

            $res_detail = $this->CleanDetailService->add($res_data['detail']);

            if ($res_detail) {
                Db::commit();
                self::showReturnCode($res_main, 0);
            } else {
                Db::rollback();
                exception('添加失败', 1001);
            }

        } catch (\Exception $e) {

            Db::rollback();
            self::showReturnCode('', 1001, $e->getMessage());
        }
    }

    /**
     * Notes: 查看评定项是否能够编辑（1：查看:2：编辑:3：新增）
     * User: myrxl
     * Date: 2020/10/12
     * Time: 11:02
     */
    public function getStatus()
    {
        $result = $this->CleanAssessmentService->getStatusList($this->user['mall_id'], $this->date);
        //type 1：晨巡 2：午巡
        $res = [
            ['type' => '1', 'status' => 3],
            ['type' => '2', 'status' => 3]
        ];

        if ($result) {
            foreach ($result as $k => $v) {
                if ($v['type'] == 1) {
                    $res[0]['status'] = 1;
                    if ($this->user['id'] == $v['user_id']) {
                        $res[0]['status'] = 2;
                    }
                }

                if ($v['type'] == 2) {
                    $res[1]['status'] = 1;
                    if ($this->user['id'] == $v['user_id']) {
                        $res[1]['status'] = 2;
                    }
                }

            }
        }

        self::showReturnCode($res, 0);
    }


    /**
     * Notes: 获取评定项信息（主表和详情表）
     * User: myrxl
     * Date: 2020/10/12
     * Time: 11:48
     */
    public function getDetailInfo()
    {
        $parame = [
            'mall_id' => $this->user['mall_id'],
            'date'    => $this->date,
            'type'    => $this->data['type']
        ];
        //获取主表数据
        $main = $this->CleanAssessmentService->getInfo($parame);
        if (!$main) {
            self::showReturnCode($data = ['main' => [], 'detail' => []], 0);
        }
        //获取详情表数据
        $where  = ['assessment_id' => $main['id'], 'enabled' => 1];
        $detail = $this->CleanDetailService->getList($where);

        $res       = $this->CleanItemService->getCleanItemList();
        $detailArr = array_column($detail, null, 'second_id');
        foreach ($res as $k => $v) {
            if (isset($detailArr[$v['id']])) {
                $res[$k]['num'] = $detailArr[$v['id']]['num'];
            }
        }
        $detailTree = toLayer($res);

        foreach ($detailTree as $kk => $vv) {
            $detailTree[$kk]['num'] = array_sum(array_column($vv['child'], 'num'));
        }

        self::showReturnCode($data = ['main' => $main, 'detail' => $detailTree], 0);
    }

    /**
     * 编辑评定项
     */
    public function edit()
    {
        (new CleanAssessmentValidate())->goCheck('edit');

        Db::startTrans();
        try {
            //查看是否有权限编辑
            $this->checkEditClean();

            //获取拼接后的数据（主表和详情表）
            $res_data = $this->getAddData();

            //修改主信息
            $this->CleanAssessmentService->editInfo($res_data['main'], $this->data['id']);

            //删除详情信息
            $this->CleanDetailService->editEnabled('0', $this->data['id']);

            //重新生成详情表数据
            foreach ($res_data['detail'] as $d => $a) {
                $res_data['detail'][$d]['assessment_id'] = $this->data['id'];
            }

            //(new CleanDetailService())->add($res_data['detail']);
            $this->CleanDetailService->add($res_data['detail']);

            Db::commit();
            self::showReturnCode($this->data['id'], 0);

        } catch (\Exception $e) {

            Db::rollback();
            self::showReturnCode('', 1001, $e->getMessage());
        }
    }

    /**
     * Notes:校验填写权限
     * User: myrxl
     * @throws \Exception
     * Date: 2020/10/13
     * Time: 14:32
     */
    private function checkAddClean()
    {
        //校验当前时间是否满足添加条件 1：是否在填写时间范围  2：是否有填写资格
        $time1 = "9:00";
        $time2 = "12:00";
        $time3 = "18:30";
        if (1 == $this->data['type']) {
            if (!checkIsBetweenTime($time1, $time2)) {
                exception('请在正确的时间内填写', 1001);
            }
        } else {
            if (!checkIsBetweenTime($time2, $time3)) {
                exception('请在正确的时间内填写', 1001);
            }
        }

        $parame = [
            'mall_id' => $this->user['mall_id'],
            'date'    => $this->date,
            'type'    => $this->data['type']
        ];
        //获取主表数据
        $main = $this->CleanAssessmentService->getInfo($parame);
        if ($main) {
            exception('请勿重复填写', 1001);
        }
    }


    /**
     * Notes: 拼接数据
     * User: myrxl
     * Date: 2020/10/12
     * Time: 9:21
     */
    private function getAddData()
    {
        $data = json_decode($this->data['data']);
        $main = [
            "pic"         => $this->data['pic'],
            "should_num"  => $this->data['should_num'],
            "arrived_num" => $this->data['arrived_num'],
            "type"        => $this->data['type'],
            "user_id"     => $this->user['id'],
            "mall_id"     => $this->user['mall_id'],
            "mall"        => $this->user['mall'],
            "date"        => $this->date,
        ];

        $detail = [];
        foreach ($data->list as $k => $v) {
            if(empty($v->child)){
                $detail[$k ]['second_name'] = "未扣分";
                $detail[$k ]['second_id']   = "1000";
                $detail[$k ]['num']         = "0";
                $detail[$k ]['first_name']  = $v->name;
                $detail[$k ]['first_id']    = $v->id;
                $detail[$k ]['enabled']     = 1;
                $detail[$k ]['type']        = $this->data['type'];

            }else{
                foreach ($v->child as $kk => $vv) {
                    //$detail[$kk]               = json_decode(json_encode($vv), true);
                    $child                           = json_decode(json_encode($vv), true);
                    $detail[$k . $kk]['second_name'] = $child['name'];
                    $detail[$k . $kk]['second_id']   = $child['id'];
                    $detail[$k . $kk]['num']         = $child['num'];
                    $detail[$k . $kk]['first_name']  = $v->name;
                    $detail[$k . $kk]['first_id']    = $v->id;
                    $detail[$k . $kk]['enabled']     = 1;
                    $detail[$k . $kk]['type']        = $this->data['type'];
                }
            }

        }
        $detail   = array_values($detail);
        $res_data = ['main' => $main, "detail" => $detail];
        return $res_data;
    }


    /**
     * Notes:校验填写权限
     * User: myrxl
     * @throws \Exception
     * Date: 2020/10/13
     * Time: 14:32
     */
    private function checkEditClean()
    {
        //校验当前时间是否满足添加条件 1：是否在填写时间范围  2：是否有填写资格
        $time1 = "9:00";
        $time2 = "12:00";
        $time3 = "18:30";
        if (1 == $this->data['type']) {
            if (!checkIsBetweenTime($time1, $time2)) {
                exception('请在正确的时间内编辑', 1001);
            }
        } else {
            if (!checkIsBetweenTime($time2, $time3)) {
                exception('请在正确的时间内编辑', 1001);
            }
        }

        $parame = [
            'mall_id' => $this->user['mall_id'],
            'date'    => $this->date,
            'type'    => $this->data['type'],
            'user_id' => $this->user['id'],
        ];
        //获取主表数据
        $main = $this->CleanAssessmentService->getInfo($parame);
        if (!$main) {
            exception('数据不存在，无法编辑', 1001);
        }
    }


}
