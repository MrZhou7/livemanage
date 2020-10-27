<?php
namespace app\api\controller\mini;
use app\service\controller\CenterService;
use think\App;

class Center extends BaseFunction
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->CenterService = new CenterService();
    }

    /**
     * Notes: 获取center 详情
     * User: myrxl
     * Date: 2019/8/21
     * Time: 18:21
     */
    public function getCenterInfo(){
        $data = $this->CenterService->getCenterInfo($this->user['id'],$this->date);
        self::showReturnCode($data,'0','ok');
    }
}