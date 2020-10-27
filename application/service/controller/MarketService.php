<?php

namespace app\service\controller;

use app\model\Market;
use think\App;

class MarketService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->MarketModel = new Market();
    }

    public function add($data)
    {
        $service    = objectToArray(json_decode($data['service_pic']));
        $enviroment = objectToArray(json_decode($data['enviroment_pic']));
        foreach ($service as $k => $v) {
            $serviceProblem[] = $v['explain'] ? $v['explain'] : '';
            $servicePic[]     = $v['pic'] ? $v['pic'] : '';
        }

        if (count($servicePic) != count($serviceProblem)) return false;
        $data['service_pic']         = implode('{|}', $servicePic);
        $data['service_explanation'] = implode('{|}', $serviceProblem);

        foreach ($enviroment as $k => $v) {
            $enviromentProblem[] = $v['explain'] ? $v['explain'] : '';
            $enviromentPic[]     = $v['pic'] ? $v['pic'] : '';
        }

        if (count($enviromentPic) != count($enviromentProblem)) return false;
        $data['enviroment_pic']         = implode('{|}', $enviromentPic);
        $data['enviroment_explanation'] = implode('{|}', $enviromentProblem);
        return $this->MarketModel->add($data);
    }


    public function getPageLists($user_id, $page)
    {
        $list = $this->MarketModel->getPageLists($user_id, $page);
        return $list;
    }

    public function getDetail($user_id, $id)
    {
        $service                = $enviroment = [];
        $detail                 = $this->MarketModel->getDetail($user_id, $id);
        $service_pic            = explode('{|}', $detail['service_pic']);
        $service_explanation    = explode('{|}', $detail['service_explanation']);
        $enviroment_pic         = explode('{|}', $detail['enviroment_pic']);
        $enviroment_explanation = explode('{|}', $detail['enviroment_explanation']);
        foreach ($service_pic as $k => $v) {
            $service[$k]['pic']    = $v;
            $service[$k]['explan'] = $service_explanation[$k];
        }
        $detail['service'] = $service;
        foreach ($enviroment_pic as $k => $v) {
            $enviroment[$k]['pic']    = $v;
            $enviroment[$k]['explan'] = $enviroment_explanation[$k];
        }
        $detail['enviroment'] = $enviroment;
        return $detail;
    }

    /**
     * Notes:后台统计列表
     * User: myrxl
     * Date: 2019/10/14
     * Time: 9:46
     */
    public function marketList($data, $page)
    {
        $list = $this->MarketModel->marketList($data, $page);
        //halt($list);
//        foreach ($list->items() as $k => $v) {
//            $servicePicArr                = explode(',', $v['service_pic']);
//            $serviceExplanationArr        = explode(',', $v['service_explanation']);
//            $list->items()[$k]['service'] = $data = $dataEnv = [];
//            foreach ($servicePicArr as $ks => $vs) {
//                $data[$ks]['pic']         = $vs;
//                $data[$ks]['explanation'] = $serviceExplanationArr[$ks];
//            }
//
//            $envPicArr         = explode(',', $v['enviroment_pic']);
//            $envExplanationArr = explode(',', $v['enviroment_explanation']);
//
//            foreach ($envPicArr as $ke => $ve) {
//                $dataEnv[$ke]['pic']         = $ve;
//                $dataEnv[$ke]['explanation'] = $envExplanationArr[$ke];
//            }
//
//            $list->items()[$k]['service'] = $data;
//            $list->items()[$k]['enviroment'] = $dataEnv;
//        }
        $dataS = $dataE = [];
        foreach ($list->items() as $k => $v) {
            $dataS['pic']                    = $v['service_pic'];
            $dataS['explanation']            = $v['service_explanation'];
            $dataE['pic']                    = $v['enviroment_pic'];
            $dataE['explanation']            = $v['enviroment_explanation'];
            $list->items()[$k]['service']    = $dataS;
            $list->items()[$k]['enviroment'] = $dataE;
        }
        return $list;
    }

}
