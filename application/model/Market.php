<?php
namespace app\model;

class Market extends BaseModel
{

    public function add($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function getInfo($map)
    {
        return $this->getBaseInfo('*',$map);
    }

    public function getPageLists($user_id, $page)
    {
        $field = 'a.*';
        $where = [
            'c.user_id' => $user_id,
        ];
        $order = "a.id desc";
        $join  = [
            ['center c', 'c.id = a.center_id']
        ];
        return $this->getPageList($field, $where, $order, $join, $page['page'], $page['limit']);
    }

    public function getDetail($user_id,$id)
    {
        $field = 'a.*';
        $map   = [
            'a.id' => $id,
            'c.user_id' => $user_id,
        ];
        $join  = [
            ['center c', 'c.id = a.center_id']
        ];
        return $this->getJoinInfo($field, $map, $join);
    }

    public function marketList($data, $page)
    {
        $field = 'a.*,u.name,c.area area_name,c.mall';
        $map   = [];
        if (isset($data['start']) && isset($data['end'])) {
            if ($data['start'] != '' && $data['end'] != '') {
                $map[] = ['a.create_time', 'between', [$data['start'], $data['end']]];
            }
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
        $order = "a.id desc";
        $join  = [
            ['center c', 'c.id = a.center_id'],
            ['user u', 'u.id = c.user_id'],
        ];
        return $this->getPageList($field, $map, $order, $join, $page['page'], $page['limit']);
    }

}