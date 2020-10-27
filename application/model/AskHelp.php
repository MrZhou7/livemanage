<?php
namespace app\model;

class AskHelp extends BaseModel
{

    public function addHelp($data)
    {
        return $this->baseSaveInfo($data);
    }

    public function getHelpList($map)
    {
        $field = 'u.name create_name,us.name deal_name,a.*';
        $map   = $map;
        $join = [
            ['user u','u.id = a.create_person','left'],
            ['user us','us.id = a.deal_person','left'],
        ];
        $order = "id desc";
        return $this->getJoinList($field, $map, $join, $order);
    }

    public function getHelpDetail($id,$user_id)
    {
        $field = 'a.*,b.name,a.status status_admin';
        $map = [
            'a.id'=>$id,
            //'create_person'=>$user_id,
        ];
        $join = [
            ['ayd_user b','b.id = a.create_person']
        ];
        return $this->getJoinInfo($field, $map, $join);
    }

    public function updateHelp($data,$id)
    {
        return $this->baseSaveInfo($data,['id'=>$id],'edit');
    }

//    public function getRankList($type1,$type2)
//    {
//
//        $field = 'u.name name,a.*';
//
//        $map = [];
//        if($type1 == 'hyjj'){
//            if($type2 == 'persons'){//火眼金睛查看个人的 （全国 区域 门店排名）
//                $map   = [
//                    'a.enabled' => 1,
//                    'u.enabled' => 1,
//                ];
//            }else{//火眼金睛查看门店的   （全国 区域排名）
//                $map   = [
//                    'a.enabled' => 1,
//                ];
//            }
//            $join = [
//                ['user u','u.id = a.create_person'],
//            ];
//        }
//
//        if($type1 == 'lkgg'){
//            if($type2 == 'persons'){//劳苦功高查看个人的 （全国 区域 门店排名）
//                $map   = [
//                    'a.status'  => 2,
//                    'a.enabled' => 1,
//                    'us.enabled' => 1,
//                ];
//            }else{//劳苦功高查看门店的   （全国 区域排名）
//                $map   = [
//                    'a.status'  => 2,
//                    'a.enabled' => 1,
//                ];
//            }
//            $join = [
//                ['user u','u.id = a.deal_person'],
//            ];
//        }
//
//
//        $order = "id desc";
//        return $this->getJoinList($field, $map, $join, $order);
//    }

    public function getRankList($type1,$type2)
    {

        $field = 'u.name name,a.*';

        $map = [];
        if($type1 == 'hyjj'){
            if($type2 == 'persons'){//火眼金睛查看个人的 （全国 区域 门店排名）
                $map   = [
                    'a.enabled' => 1,
                    'u.enabled' => 1,
                ];
            }else{//火眼金睛查看门店的   （全国 区域排名）
                $map   = [
                    'a.enabled' => 1,
                ];
            }
            $join = [
                ['user u','u.id = a.create_person'],
            ];
        }

        if($type1 == 'lkgg'){
            if($type2 == 'persons'){//劳苦功高查看个人的 （全国 区域 门店排名）
                $map   = [
                    'a.status'  => 2,
                    'a.enabled' => 1,
                    'us.enabled' => 1,
                ];
            }else{//劳苦功高查看门店的   （全国 区域排名）
                $map   = [
                    'a.status'  => 2,
                    'a.enabled' => 1,
                ];
            }
            $join = [
                ['user u','u.id = a.deal_person'],
            ];
        }


        $order = "id desc";
        return $this->getJoinList($field, $map, $join, $order);
    }



//    public function ranking($type)
//    {
//        if ($type == 'person_create') {
//            $field = "u.name create_name,count('create_person') num";
//            $group = "create_person,create_name";
//            $map   = [
//                'a.enabled' => 1,
//                'u.enabled' => 1,
//            ];
//            $join  = [
//                ['user u', 'u.id = a.create_person', 'left'],
//            ];
//        } else if ($type == 'person_deal') {
//            $field = "u.name deal_name,count('deal_person') num";
//            $group = "deal_person,deal_name";
//            $map   = [
//                'a.status'  => 2,
//                'a.enabled' => 1,
//                'u.enabled' => 1,
//            ];
//            $join  = [
//                ['user u', 'u.id = a.deal_person', 'left'],
//            ];
//        } else if ($type == 'mall_create') {
//            $field = "a.mall mall_name,count('mall') num";
//            $group = "mall_name";
//            $map   = [
//                'a.enabled' => 1,
//            ];
//            $join  = [];
//        } else if ($type == 'mall_deal') {
//            $field = "a.deal_mall deal_mall_name,count('deal_mall') num";
//            $group = "deal_mall_name";
//            $map   = [
//                'a.status'  => 2,
//                'a.enabled' => 1,
//            ];
//            $join  = [];
//        }
//        $list = $this->alias('a')->field($field)
//            ->where($map)
//            ->join($join)
//            ->group($group)
//            ->select();
//        return $list;
//    }


    public function ranking($field,$map,$join,$group)
    {
        $list = $this->alias('a')->field($field)
            ->where($map)
            ->join($join)
            ->group($group)
            ->select()->toArray();
        return $list;
    }


    public function produceProblem($data,$data2)
    {
        if(isset($data2['area_id'])){
            if($data2['area_id'] != ''){
                $map[] = ['area_id','=',$data2['area_id']];
            }
        }
        if(isset($data2['mall_id'])){
            if($data2['mall_id'] != ''){
                $map[] = ['mall_id','=',$data2['mall_id']];
            }
        }
        $map[] = $data;
        return $this->count($map);
    }

    public function solveProblem($data,$data2)
    {
        if(isset($data2['area_id'])){
            if($data2['area_id'] != ''){
                $map[] = ['area_id','=',$data2['area_id']];
            }
        }
        if(isset($data2['mall_id'])){
            if($data2['mall_id'] != ''){
                $map[] = ['mall_id','=',$data2['mall_id']];
            }
        }
        $map[] = $data;
        $map[] = ['status','=','2'];//finish_time
        return $this->count($map);
    }


    public function avgtime($data2){
        if(isset($data2['area_id'])){
            if($data2['area_id'] != ''){
                $map[] = ['area_id','=',$data2['area_id']];
            }
        }
        if(isset($data2['mall_id'])){
            if($data2['mall_id'] != ''){
                $map[] = ['mall_id','=',$data2['mall_id']];
            }
        }
        $map[] = ['duration','<>',''];
        return $this->where($map)->avg('duration');
    }

    public function getStatList($data,$userId){
        // 时间
        $field = 'id,create_person';
        $map[] = ['create_person', 'in', $userId];
        if (isset($data['start']) && isset($data['end'])) {
            if ($data['start'] != '' && $data['end'] != '') {
                $map[] = ['create_time', 'between', [$data['start'], $data['end']]];
            }
        }

        if (isset($data['area_id'])) {
            if ($data['area_id'] != '') {
                $map[] = ['area_id', '=', $data['area_id']];
            }
        }
        if (isset($data['mall_id'])) {
            if ($data['mall_id'] != '') {
                $map[] = ['mall_id', '=', $data['mall_id']];
            }
        }
        $order = 'id desc';
        return $this->getList($field, $map,$order);
    }


}