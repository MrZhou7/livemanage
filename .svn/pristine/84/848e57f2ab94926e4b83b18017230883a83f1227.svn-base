<?php
namespace app\model;

class Center extends BaseModel
{
    public function checkCenterIsSet($id,$date='')
    {
        $map = [
            'user_id' => $id,
            'date'    => $date ? $date :date('Y-m-d', time())
        ];
        return $this->where($map)->find();
    }

    public function addInfo($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function updateStatus($data,$id){
        $map = [
            'id'=>$id,
        ];
        return $this->baseSaveInfo($data,$map,"edit");
    }

    public function getDetail($date,$type,$user_id){
        $field = 'b.*';
        $map = [
            'a.date' =>$date,
            'a.user_id' =>$user_id,
        ];
        $join = [
            ["ayd_"."{$type}".' b','a.id = b.center_id','left']
        ];
        return $this->getDistinctJoinInfo($field,$map,$join);
    }

    public function getDetailById($data,$type){
        $field = 'b.*,a.date';
        $map   = [
            'b.id'      => $data['id'],
            'b.enabled' => 1,
        ];
        $join  = [
            ["ayd_" . "{$type}" . ' b', 'a.id = b.center_id']
        ];
        return $this->getDistinctJoinInfo($field, $map, $join);
    }

    public function getQuyu(){
        $field = 'area_id,area';
        $where = [];
        $join  = [];
        return $this->getDistinctJoinList($field, $where, $join);
    }

    public function getMall($area_id){
        $field = 'mall_id,mall';
        $where = [
            'area_id' => $area_id
        ];
        $join  = [];
        return $this->getDistinctJoinList($field, $where, $join);
    }
    //请假列表
    public function holidayList($data, $centerId)
    {
        // 时间
        $field = 'm.id,a.id center_id';
        $map[] = ['a.id', 'in', $centerId];
        $order = 'm.id desc';
        $join  = [
            ['matter_record m', "a.id = m.center_id and m.enabled = 1 and m.work = 1 and m.create_time < '{$data['end']}'", 'left'],
        ];
        return $this->getJoinList($field, $map, $join, $order);
    }

    //事项记录列表
    public function recordList($data, $centerId)
    {
        // 时间
        $field = 'm.id,a.id center_id';
        $map[] = ['a.id', 'in', $centerId];
        $order = 'm.id desc';
        $join  = [
            ['matter_record m', "a.id = m.center_id", 'left'],
        ];
        return $this->getJoinList($field, $map, $join, $order);
    }



}