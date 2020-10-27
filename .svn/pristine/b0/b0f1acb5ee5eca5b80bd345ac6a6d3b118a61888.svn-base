<?php

namespace app\model;

class Article extends BaseModel
{

    public function add($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function lists($arr, $page)
    {
        if (isset($arr['column'])) {
            if ($arr['column']) {
                $map[] = ['a.column', '=', $arr['column']];
            }
        }
        $map[] = ['a.enabled', '=', 1];
        $field = 'a.*,c.name,c.id cid';
        $join  = [
            ['column c', 'c.id = a.column']
        ];
        $order = 'sort desc id desc';
        //return $this->getPageList($field, $map, $order, $join, $page['page'], $page['limit']);
        return $this->alias('a')->field($field)->where($map)->join($join)->order($order)
            ->paginate($page['limit'], false, ['page' => $page['page'], 'query' => request()->param()]);
    }

    public function getInfo($id)
    {
        $field = 'a.*,c.name';
        $map   = [
            'a.id' => $id,
        ];
        $join  = [
            ['column c', 'c.id = a.column', 'left']
        ];
        $data  = $this->getJoinInfo($field, $map, $join);
        return $data;
    }

    public function edit($data)
    {
        $map = [
            'id' => $data['id'],
        ];
        unset($data['id']);
        $res = $this->baseSaveInfo($data, $map, 'edit');
        return $res;
    }

    public function getNoticeList($arr)
    {
        $field = 'id,title';
        $map   = [
            'enabled' => 1,
            'column'  => $arr['column']
        ];
        $order = 'sort desc id desc';
        $list  = $this->field($field)->where($map)->order($order)->limit(4)->select()->toArray();
        return $list;
    }

    public function getRuleList($arr)
    {
        $field = 'a.id,title,name,c.id cid';
        $map   = [
            'a.enabled' => 1,
            'c.pid'     => $arr['pid'],
            'c.enabled' => 1
        ];
        $join  = [
            ['column c', 'c.id = a.column'],
        ];
        $order = 'a.sort desc a.id desc';
        $list  = $this->getJoinList($field, $map, $join, $order);
        return $list;
    }

}