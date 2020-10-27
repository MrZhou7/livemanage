<?php
namespace app\service\controller;
use app\model\MatterRecord;
use think\App;
class MatterRecordService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->MatterRecordModel = new MatterRecord();
    }

    public function add($data)
    {
        return $this->MatterRecordModel->add($data);
    }

    public function getInfo($map)
    {
        return $this->MatterRecordModel->getInfo($map);
    }

    public function getJoinInfo($user_id, $date)
    {
        $field = 'a.*';
        $where = [
            'c.user_id' => $user_id,
            'c.date'    => $date,
            'c.enabled' => 1,
        ];
        $join  = [
            ['center c', 'c.id = a.center_id']
        ];
        return $this->MatterRecordModel->getJoinInfo($field, $where, $join);
    }

    public function importantList($data, $page ,$type = 'important')
    {
        if($type == 'important'){
            $field = 'a.id,a.important,c.mall,c.area,u.name,a.create_time';
            $map[] = ['a.important', '<>', ''];
        }else{
            $field = 'a.id,a.lightspot,c.mall,c.area,u.name,a.create_time';
            $map[] = ['a.lightspot', '<>', ''];
        }
        if (isset($data['area_id'])) {
            if ($data['area_id'] != '') {
                $map[] = ['c.area_id', '=', $data['area_id']];
            }
        }
        if (isset($data['mall_id'])) {
            if ($data['mall_id'] != '') {
                $map[] = ['c.mall_id', '=', $data['mall_id']];
            }
        }

        $map[] = ['c.enabled', '=', 1];
        $map[] = ['a.enabled', '=', 1];

        $order = 'a.id desc';
        $join  = [
            ['center c', 'c.id = a.center_id'],
            ['user u', 'u.id = c.user_id'],
        ];
        return $this->MatterRecordModel->getPageList($field, $map, $order, $join, $page['page'], $page['limit']);
    }



}
