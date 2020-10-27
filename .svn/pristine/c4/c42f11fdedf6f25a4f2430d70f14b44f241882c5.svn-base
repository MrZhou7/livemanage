<?php
namespace app\model;

class Column extends BaseModel
{

    public function add($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function lists(){
        $field = '*';
        $map = [
            'enabled'=>1,
        ];
        $order = 'sort desc id desc';
        return $this->getList($field,$map,$order);
    }

    public function getInfo($id)
    {
        $field = 'a.*,c.name pname';
        $map = [
            'a.id'=>$id,
        ];
        $join = [
            ['column c','c.id = a.pid','left']
        ];
        $data = $this->getJoinInfo($field,$map,$join);
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
}