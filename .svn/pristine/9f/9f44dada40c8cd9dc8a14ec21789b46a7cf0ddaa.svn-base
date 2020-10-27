<?php
namespace app\model;

class Advice extends BaseModel
{

    public function add($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function getPageLists($user_id = '', $page)
    {
        $field = 'a.*';
        if ($user_id) {
            $where = ['a.user_id' => $user_id];
        } else {
            $where = [];
        }
        $order = "a.id desc";
        $join  = [];
        return $this->getPageList($field, $where, $order, $join, $page['page'], $page['limit']);
    }

    public function getDetail($user_id,$id)
    {
        $field = 'a.*';
        $map   = [
            'a.id'      => $id,
            'a.user_id' => $user_id,
        ];
        $join  = [];
        return $this->getJoinInfo($field, $map, $join);
    }

}