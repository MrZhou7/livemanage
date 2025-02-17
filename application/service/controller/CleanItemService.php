<?php

namespace app\service\controller;

use app\model\CleanItem;
use think\App;

class CleanItemService extends BaseService
{
    private $CleanItemModel;

    public function __construct(App $app = null)
    {
        $this->CleanItemModel = new CleanItem();
    }

    /**
     * Notes:获取列表
     * User: myrxl
     * @return array
     * Date: 2020/10/20
     * Time: 11:21
     */
    public function getCleanItemList()
    {
        $newData = [];
        $res     = $this->CleanItemModel->getList("*,0 num", ["enabled" => 1]);
        foreach ($res as $k => $v) {
            if ($v['pid'] == 0) {
                $newData[] = [
                    "id"          => 10000,
                    "name"        => "不扣分",
                    "type"        => 0,
                    "pid"         => $v['id'],
                    "enabled"     => 1,
                    "create_time" => "2020-10-13 09:49:37",
                    "update_time" => "2020-10-13 09:49:37",
                    "num"         => 0,
                    "one"         => 1,
                    "two"         => 2,
                    "checked"     => false,
                    "showList"    => []
                ];
            }


            if (1 === $v['type']) {
                $res[$k]['one']      = 1;
                $res[$k]['two']      = 2;
                $res[$k]['checked']  = false;
                $res[$k]['showList'] = [];
            } else {
                $res[$k]['one']      = 0.5;
                $res[$k]['two']      = 1;
                $res[$k]['checked']  = false;
                $res[$k]['showList'] = [];
            }
        }
        $data = array_merge($newData, $res);
        return $data;
    }

    /**
     * Notes: 获取一级类目列表
     * User: myrxl
     * @return array
     * Date: 2020/10/15
     * Time: 13:47
     */
    public function getFirstList()
    {
        $res = $this->CleanItemModel->getList("*", ["enabled" => 1, "pid" => 0]);
        return $res;
    }

}
