<?php
namespace app\service\controller;
use app\model\Center;
use app\model\MorningMeeting;
use app\model\Welcome;
use app\model\MorningTour;
use app\model\AfternoonTour;
use app\model\Interview;
use app\model\Send;
use think\Db;
class InterviewService extends BaseService
{
    private $centerid;
    public function __construct($id = '')
    {
        parent::__construct();
        $this->centerid = $id;
    }



    public function checkCenterIsSet($data){
        $model = new Center();
        $res   = $model->checkCenterIsSet($data['id']);
        if (!$res) {
            $data = [
                'user_id' => $data['id'],
                'area_id' => $data['area_id'],
                'area'    => $data['area'],
                'mall_id' => $data['mall_id'],
                'mall'    => $data['mall'],
                'date'    => date('Y-m-d', time()),
            ];
            //新增一条记录
            $model->addInfo($data);
            $id = $model->id;
        } else {
            $id = (int)$res['id'];
        }
        return $id;
    }

    public function getDetail($date,$type,$user){
        $dataInfo = (new Center())->getDetail($date,$type,$user);
        if($dataInfo){
            if ($type == 'morning_tour' || $type == 'afternoon_tour') {
                $pic = explode('{|}',$dataInfo['pic']);
                $problem = explode('{|}',$dataInfo['problem']);
                foreach ($pic as $k=>$v){
                    $info[$k]['pic'] = $v;
                    $info[$k]['problem'] = $problem[$k];
                }
                $dataInfo['question'] = $info;
            }
        }
        return $dataInfo;
    }

    public function updateCenterStatus($data){
        return (new Center())->updateStatus($data, $this->centerid);
    }


    public function addInterview($data,$type)
    {
        Db::startTrans();
        $model = $this->getModel($type);
        $data['center_id'] = $this->centerid;
        $add               = $model->addInfo($data);
        $update            = $this->updateCenterStatus(['is_'.$type => 1]);
        if ($update && $add !== -1 && $add) {
            Db::commit();
            return true;
        } else {
            Db::rollback();
            return false;
        }
    }

    public function getModel($type){
        switch ($type){
            case "morning_meeting":
                $model = (new MorningMeeting());
                break;
            case "welcome":
                $model = (new Welcome());
                break;
            case "morning_tour":
                $model = (new MorningTour());
                break;
            case "afternoon_tour":
                $model = (new AfternoonTour());
                break;
            case "interview":
                $model = (new Interview());
                break;
            case "send":
                $model = (new Send());
                break;
        }
        return $model;
    }

    public function updateInterview($data, $type)
    {
        $detail = (new Center())->getDetailById($data, $type);
        if ($detail['date'] != date('Y-m-d', time())) return 'NOTTODAY';
        $model = $this->getModel($type);
        $id    = $data['id'];
        unset($data['id']);
        $res = $model->baseSaveInfo($data, ['id' => $id], 'edit');
        return $res;
    }



}
