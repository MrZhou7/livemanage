<?php
namespace app\service\controller;
use app\model\AskHelp;
class AskHelpService extends BaseService
{
    public function __construct()
    {
        $this->AskHelpModel = new AskHelp();
    }



    public function addHelp($data, $user)
    {
        $dataUser = [
            'create_person' => $user['id'],
            'area_id'       => $user['area_id'],
            'area'          => $user['area'],
            'mall_id'       => $user['mall_id'],
            'mall'          => $user['mall'],
        ];
        $data     = array_merge($data, $dataUser);
        return $this->AskHelpModel->addHelp($data);
    }

    public function getHelpList($data, $user)
    {
        $status = $data['status'];
        if ($status == '-1') {
            $map[] = ['a.status', 'in', [0, 3]];
            $map[] = ['emergency', '=', 1];
            $map[] = ['a.mall_id', '=', $user['mall_id']];
        } elseif ($status == '0') {
            $map[] = ['a.status', 'in', [0, 3]];
            $map[] = ['emergency', '=', 0];
            $map[] = ['a.mall_id', '=', $user['mall_id']];
        } elseif ($status == '1' || $status == '2') {
            $map = ['status' => $status, 'a.mall_id' => $user['mall_id']];
        } else {
            return false;
        }

        return $this->AskHelpModel->getHelpList($map);
    }


    public function getHelpDetail($data, $user){
        return $this->AskHelpModel->getHelpDetail($data['id'], $user['id']);
    }

    public function updateHelp($data, $user){
        $helpInfo = $this->AskHelpModel->getHelpDetail($data['id'], $user['id']);
        if(!$helpInfo) return false;
        $arr = [
            0 => [1],
            1 => [2, 3],
            3 => [1,2],
        ];
        if(in_array($data['status'],$arr[$helpInfo['status']])){
            if($data['status'] == 1){//待验收
                $dataInfo = [
                    'deal_person'  => $user['id'],
                    'deal_mall_id' => $user['mall_id'],
                    'deal_mall'    => $user['mall'],
                    'deal_area_id' => $user['area_id'],
                    'deal_area'    => $user['area'],
                    'solve_pic'    => $data['solve_pic'],
                ];
            }
            if($data['status'] == 2){//已完成
                $dataInfo = [
                    'finish_person' => $user['id'],
                    'finish_time'   => date('Y-m-d H:i:s', time()),
                    'duration'      => time() - strtotime($helpInfo['create_time']),
                ];
            }
            if ($data['status'] == 3) {//需改进
                $dataInfo = [
                    'finish_person' => $user['id'],
                    'improvement'   => $data['improvement'],
                ];
            }
            $dataInfo['status'] = $data['status'];
        }else{
            return false;
        }
        return $this->AskHelpModel->updateHelp($dataInfo, $data['id']);
    }



    public function ranking($type1, $type2, $user)
    {
        $dataInfo =[];
        if ($type1 == 'hyjj') {
            if ($type2 == 'person') {//火眼金睛查看个人的 （全国 区域 门店排名）
                //查看全国的
                $field   = "u.name name,count('create_person') num";
                $group   = "create_person,name";
                $map     = [
                    'a.enabled' => 1,
                    'u.enabled' => 1,
                ];
                $join    = [
                    ['user u', 'u.id = a.create_person'],
                ];
                $country = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num     = array_column($country, 'num');
                array_multisort($num, SORT_DESC, $country);

                //查看区域的
                $map  = [
                    'a.enabled' => 1,
                    'a.area_id' => $user['area_id'],
                    'u.enabled' => 1,
                ];
                $area = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($area, 'num');
                array_multisort($num, SORT_DESC, $area);

                //查看门店的
                $map  = [
                    'a.enabled' => 1,
                    'a.mall_id' => $user['mall_id'],
                    'u.enabled' => 1,
                ];
                $mall = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($mall, 'num');
                array_multisort($num, SORT_DESC, $mall);
                $dataInfo = [
                    'country' => $country,
                    'area'    => $area,
                    'mall'    => $mall,
                ];

            } else {//火眼金睛查看门店的   （全国 区域排名）
                //查看全国的
                $field   = "a.mall name,count('mall_id') num";
                $group   = "mall_id,name";
                $map     = [
                    'a.enabled' => 1,
                ];
                $join    = [];
                $country = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num     = array_column($country, 'num');
                array_multisort($num, SORT_DESC, $country);

                //查看区域的
                $map = [
                    'a.enabled' => 1,
                    'a.area_id' => $user['area_id'],
                ];
                $join = [];
                $area = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($area, 'num');
                array_multisort($num, SORT_DESC, $area);
                $dataInfo = [
                    'country' => $country,
                    'area'    => $area,
                ];
            }
        } else if ($type1 == 'lkgg') {

            if ($type2 == 'person') {//劳苦功高查看个人的 （全国 区域 门店排名）
                //查看全国的
                $field   = "u.name name,count('deal_person') num";
                $group   = "deal_person,name";
                $map     = [
                    'a.enabled' => 1,
                    'a.status'  => 2,
                    'u.enabled' => 1,
                ];
                $join    = [
                    ['user u', 'u.id = a.deal_person'],
                ];
                $country = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num     = array_column($country, 'num');
                array_multisort($num, SORT_DESC, $country);

                //查看区域的
                $map  = [
                    'a.enabled' => 1,
                    'a.area_id' => $user['area_id'],
                    'a.status'  => 2,
                    'u.enabled' => 1,
                ];
                $area = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($area, 'num');
                array_multisort($num, SORT_DESC, $area);

                //查看门店的
                $map  = [
                    'a.enabled' => 1,
                    'a.mall_id' => $user['mall_id'],
                    'a.status'  => 2,
                    'u.enabled' => 1,
                ];
                $mall = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($mall, 'num');
                array_multisort($num, SORT_DESC, $mall);
                $dataInfo = [
                    'country' => $country,
                    'area'    => $area,
                    'mall'    => $mall,
                ];

            } else {//劳苦功高查看门店的   （全国 区域排名）
                //查看全国的
                $field   = "a.deal_mall name,count('deal_mall_id') num";
                $group   = "deal_mall_id,name";
                $map     = [
                    'a.enabled' => 1,
                    'a.status'  => 2,
                ];
                $join    = [];
                $country = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num     = array_column($country, 'num');
                array_multisort($num, SORT_DESC, $country);

                //查看区域的
                $map  = [
                    'a.enabled' => 1,
                    'a.area_id' => $user['area_id'],
                    'a.status'  => 2,
                ];
                $area = $this->AskHelpModel->ranking($field, $map, $join, $group);
                $num  = array_column($area, 'num');
                array_multisort($num, SORT_DESC, $area);
                $dataInfo = [
                    'country' => $country,
                    'area'    => $area,
                ];
            }
        }
        return $dataInfo;
    }

    public function produceProblem($map){
        $week         = find_createtime(2);
        $month        = find_createtime(3);
        $quarter      = find_createtime(4);
        $weekCount    = $this->AskHelpModel->produceProblem($week,$map);
        $monthCount   = $this->AskHelpModel->produceProblem($month,$map);
        $quarterCount = $this->AskHelpModel->produceProblem($quarter,$map);
        $data         = [
            "week"    => $weekCount,
            "month"   => $monthCount,
            "quarter" => $quarterCount,
        ];
        return $data;
    }

    public function solveProblem($map){
        $week         = find_createtime(2,'finish_time');
        $month        = find_createtime(3,'finish_time');
        $quarter      = find_createtime(4,'finish_time');
        $weekCount    = $this->AskHelpModel->solveProblem($week,$map);
        $monthCount   = $this->AskHelpModel->solveProblem($month,$map);
        $quarterCount = $this->AskHelpModel->solveProblem($quarter,$map);
        $data         = [
            "week"    => $weekCount,
            "month"   => $monthCount,
            "quarter" => $quarterCount,
        ];
        return $data;
    }

    public function avgtime($map){
        $time    = $this->AskHelpModel->avgtime($map);
        $str = Sec2Time($time);
        return $str;
    }

    public function getStatList($data,$userId){
        return $this->AskHelpModel->getStatList($data,$userId);
    }
}
