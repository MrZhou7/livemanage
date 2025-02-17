<?php

namespace app\service\controller;

use app\model\CleanAssessment;
use think\App;

class CleanAssessmentService extends BaseService
{

    private $CleanAssessmentModel;

    public function __construct(App $app = null)
    {
        $this->CleanAssessmentModel = new CleanAssessment();
    }

    /**
     * Notes:新增保洁评定主表信息
     * User: myrxl
     * @param $data
     * @return bool
     * Date: 2020/10/12
     * Time: 10:07
     */
    public function add($data)
    {
        return $this->CleanAssessmentModel->add($data);
    }

    /**
     * Notes: 获取主表详情
     * User: myrxl
     * @param $data
     * @return array|bool
     * Date: 2020/10/13
     * Time: 14:18
     */
    public function getInfo($data)
    {
        return $this->CleanAssessmentModel->getBaseInfo("*", $data);
    }

    /**
     * Notes:查看评定项信息
     * User: myrxl
     * @param $mall_id
     * @param $date
     * @return mixed
     * Date: 2020/10/13
     * Time: 14:07
     */
    public function getStatusList($mall_id, $date)
    {
        return $this->CleanAssessmentModel->getStatusList($mall_id, $date);
    }

    /**
     * Notes:修改主表信息
     * User: myrxl
     * @param $data
     * @param $id
     * @return array|bool
     * Date: 2020/10/13
     * Time: 14:45
     */
    public function editInfo($data, $id)
    {
        return $this->CleanAssessmentModel->baseSaveInfo($data, ['id' => $id], 'edit');
    }

    /**
     * Notes:获取月度评定表基础数据
     * User: myrxl
     * @param $mall_id
     * @param $date
     * @return array
     * Date: 2020/10/15
     * Time: 15:30
     */
    public function getMonthList($mall_id, $date)
    {
        $date = currentMonth($date);

        $field = 'a.mall_id,a.mall,a.date,a.should_num,d.*';
        $map   = [
            ["a.mall_id", "in", $mall_id],
            ["a.enabled", "=", 1],
            ["d.enabled", "=", 1],
            ["a.date", "between", [$date['start'], $date['end']]],
        ];
        $join  = [
            ['clean_detail d', "d.assessment_id = a.id", "left"]
        ];
        return $this->CleanAssessmentModel->getJoinList($field, $map, $join);
    }

    /**
     * Notes:获取主表详情
     * User: myrxl
     * @param $mall_id
     * @param $start
     * @param $end
     * @return array
     * Date: 2020/10/20
     * Time: 15:27
     */
    public function getList($mall_id, $start, $end)
    {
        $map = [
            ['mall_id', "in", [$mall_id]],
            ['date', "between", [$start, $end]],
        ];
        return $this->CleanAssessmentModel->getList("*", $map);
    }

}
