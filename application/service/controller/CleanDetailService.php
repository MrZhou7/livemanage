<?php

namespace app\service\controller;

use app\model\CleanDetail;
use think\App;

class CleanDetailService extends BaseService
{
    private $CleanDetailModel;

    public function __construct(App $app = null)
    {
        $this->CleanDetailModel = new CleanDetail();
    }

    /**
     * Notes: 新增保洁评定详情数据
     * User: myrxl
     * @param $data
     * @return bool
     * Date: 2020/10/12
     * Time: 9:54
     */
    public function add($data)
    {
        return $this->CleanDetailModel->add($data);
    }

    /**
     * Notes: 获取列表
     * User: myrxl
     * @param $data
     * @return bool
     * Date: 2020/10/12
     * Time: 17:17
     */
    public function getList($map)
    {
        return $this->CleanDetailModel->getList("*", $map, "", "first_id asc");
    }

    /**
     * Notes: 获取列表
     * User: myrxl
     * @param $data
     * @return bool
     * Date: 2020/10/12
     * Time: 17:17
     */
    public function getJoinList($data)
    {
        $map  = [
            ['assessment_id', 'in', array_column($data, 'id')],
            ['a.enabled', '=', 1],
            ['i.enabled', '=', 1],
        ];
        $join = [
            ['clean_item i', "i.id = a.first_id", "left"]
        ];
        return $this->CleanDetailModel->getJoinList("a.*,i.type item_type", $map, $join, "first_id asc");
    }


    /**
     * Notes:修改Enabled
     * User: myrxl
     * @param $enabled
     * @param $assessment_id
     * @return bool
     * Date: 2020/10/13
     * Time: 14:51
     */
    public function editEnabled($enabled, $assessment_id)
    {
        return $this->CleanDetailModel->editEnabled($enabled, $assessment_id, 'edit');
    }

    /**
     * Notes:分组查询详情
     * User: myrxl
     * @param $assessment_id
     * @return array|\PDOStatement|string|\think\Collection
     * Date: 2020/10/20
     * Time: 16:06
     */
    public function getGroupByList($assessment_id)
    {
        return $this->CleanDetailModel->getGroupByList($assessment_id);
    }
}
