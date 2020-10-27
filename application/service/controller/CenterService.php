<?php
namespace app\service\controller;
use app\model\Center;
use think\App;
class CenterService extends BaseService
{
    public function __construct(App $app = null)
    {
        $this->CenterModel = new Center();
    }

    public function getCenterInfo($user_id,$date=''){
        return $this->CenterModel->checkCenterIsSet($user_id,$date);
    }

    public function getQuyu(){
        return $this->CenterModel->getQuyu();
    }
    public function getMall($area_id){
        return $this->CenterModel->getMall($area_id);
    }

    public function getUserList($data,$page){

    }


    public function sceneList($data, $page)
    {
        $userList = (new UserService())->getUserList($data, $page);
        if (!$userList->items()) return ['count' => 0, 'data' => []];
        foreach ($userList->items() as $k => $v) {
            $userId[] = $v['id'];
        }
        //人员列表 （我在现场天数）
        $sceneList = (new UserService())->sceneList($data, $userId);

        $centerId  = array_column($sceneList, 'id');
        //请假天数
        $holiday = $this->CenterModel->holidayList($data, $centerId);
        //事项记录
        $record = $this->CenterModel->recordList($data, $centerId);
        //寻求帮助
        $help     = (new AskHelpService())->getStatList($data, $userId);

        $dataInfo = [];
        if($help){
            foreach ($help as $k => $v) {
                $helpData[$v['create_person']][] = $v;
            }
            unset($help);
            foreach ($helpData as $k => $v) {
                $helpDataInfo[$k] = count($v);
            }
            unset($helpData);
        }

        if($holiday){
            foreach ($holiday as $k => $v) {
                if ($v['id'] == '') {
                    $holidayData[$v['center_id']] = [];
                } else {
                    $holidayData[$v['center_id']][] = $v;
                }
            }
            unset($holiday);
            foreach ($holidayData as $k => $v) {
                $holidayDataInfo[$k] = count($v);
            }
            unset($holidayData);
        }
        if($record){
            foreach ($record as $k => $v) {
                if ($v['id'] == '') {
                    $recordData[$v['center_id']] = [];
                } else {
                    $recordData[$v['center_id']][] = $v;
                }
            }
            unset($record);
            foreach ($recordData as $k => $v) {
                $recordDataInfo[$k] = count($v);
            }
            unset($recordData);
        }

        foreach ($sceneList as $k => $v) {
            if (isset($holidayDataInfo[$v['id']])) {
                $sceneList[$k]['holiday'] = $holidayDataInfo[$v['id']];
            } else {
                $sceneList[$k]['holiday'] = 0;
            }

            if (isset($recordDataInfo[$v['id']])) {
                $sceneList[$k]['record'] = $recordDataInfo[$v['id']];
            } else {
                $sceneList[$k]['record'] = 0;
            }
        }

        foreach ($centerId as $k => $v) {
            if (!$v) unset($centerId[$k]);
        }
        if($sceneList){
            foreach ($sceneList as $k => $v) {
                if ($v['id'] == '') {
                    $datas[$v['a_user_id']]['list'] = [];
                } else {
                    $datas[$v['a_user_id']]['list'][] = $v;
                }
                $datas[$v['a_user_id']]['name']    = $v['name'];
                $datas[$v['a_user_id']]['mall']    = $v['mall'];
                $datas[$v['a_user_id']]['area']    = $v['area'];
                $datas[$v['a_user_id']]['holiday'] = $v['holiday'];
                $datas[$v['a_user_id']]['record']  = $v['record'];
            }
            unset($sceneList);
            foreach ($datas as $k => $v) {
                $dataInfo[$k]['name']    = $v['name'];
                $dataInfo[$k]['mall']    = $v['mall'];
                $dataInfo[$k]['area']    = $v['area'];
                $dataInfo[$k]['holiday'] = $v['holiday'];
                $dataInfo[$k]['record']  = $v['record'];
                $dataInfo[$k]['count']   = count($v['list']);
                if (isset($helpDataInfo[$k])) {
                    $dataInfo[$k]['help'] = $helpDataInfo[$k];
                } else {
                    $dataInfo[$k]['help'] = 0;
                }
            }
            unset($datas);
            $dataInfo = array_values($dataInfo);
        }

        return ['count' => $userList->total(), 'data' => $dataInfo];
    }




}
