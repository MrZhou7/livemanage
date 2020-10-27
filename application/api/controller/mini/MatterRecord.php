<?php

namespace app\api\controller\mini;

use app\api\validate\MatterRecordValidate;
use app\service\controller\MatterRecordService;
use think\App;

class MatterRecord extends BaseFunction
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->MatterRecordService = new MatterRecordService();
    }

    /**
     * Notes: 添加事项记录
     * User: myrxl
     * Date: 2019/8/26
     * Time: 15:09
     */
    public function add()
    {
        //(new MatterRecordValidate())->goCheck('add');
        $this->data['center_id'] = (new Interview())->checkCenterIsSet();
        $detail                  = $this->MatterRecordService->getInfo(['center_id' => $this->data['center_id']]);
        if ($detail) self::showReturnCode('', 1001, '请勿重复添加');
        $res = $this->MatterRecordService->add($this->data);
        if ($res < 0) {
            self::showReturnCode('', 1001, '添加失败');
        } else {
            self::showReturnCode('', 0, 'ok');
        }
    }

    /**
     * Notes: 获取详情
     * User: myrxl
     * Date: 2019/8/26
     * Time: 16:13
     */
    public function getInfo()
    {
        //根据日期 用户信息获取 详情
        $detail = $this->MatterRecordService->getJoinInfo($this->user['id'], $this->date);
        self::showReturnCode($detail, 0, 'ok');
    }
}