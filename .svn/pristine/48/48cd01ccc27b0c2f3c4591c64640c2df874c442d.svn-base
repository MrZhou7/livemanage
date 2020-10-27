<?php
namespace app\service\controller;
use app\model\Advice;
use think\App;
class AdviceService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->AdviceModel = new Advice();
    }

    public function add($data,$user)
    {
        $data = [
            'advice'  => $data['advice'],
            'user_id' => $user['id'],
            'name'    => $user['name'],
            'mall'    => $user['mall'],
            'mall_id' => $user['mall_id'],
            'area'    => $user['area'],
            'area_id' => $user['area_id'],
        ];
        return $this->AdviceModel->add($data);
    }


    public function getPageLists($user_id, $page)
    {
        $list = $this->AdviceModel->getPageLists($user_id, $page);
        return $list;
    }

    public function getDetail($user_id,$id){
        $detail = $this->AdviceModel->getDetail($user_id,$id);
        return $detail;
    }


}
