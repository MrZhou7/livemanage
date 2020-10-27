<?php
namespace app\api\controller\mini;
use app\service\controller\AskHelpService;
use app\api\validate\AskHelpValidate;
use think\App;

class AskHelp extends BaseFunction
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * Notes: 添加寻求帮助接口
     * User: myrxl
     * Date: 2019/8/22
     * Time: 16:01
     */
    public function addHelp()
    {
        (new AskHelpValidate())->goCheck('add');
        $res = (new AskHelpService($this->user))->addHelp($this->data,$this->user);
        if ($res) {
            self::showReturnCode('', 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }

    /**
     * Notes:获取寻求帮助列表
     * User: myrxl
     * Date: 2019/8/23
     * Time: 09:29
     */
    public function getHelpList()
    {
        (new AskHelpValidate())->goCheck('getList');
        $res = (new AskHelpService())->getHelpList($this->data, $this->user);
        if ($res) {
            self::showReturnCode($res, 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '暂无信息');
        }
    }

    /**
     * Notes:获取寻求帮助详情
     * User: myrxl
     * Date: 2019/8/22
     * Time: 20:02
     */
    public function getHelpDetail()
    {
        (new AskHelpValidate())->goCheck('getDetail');
        $res = (new AskHelpService())->getHelpDetail($this->data, $this->user);
        if ($res) {
            self::showReturnCode($res, 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '暂无信息');
        }
    }

    /**
     * Notes:修改信息（待处理，待验收）
     * User: myrxl
     * Date: 2019/8/23
     * Time: 8:38
     */
    public function updateHelp()
    {
        if (!isset($this->data['status'])) self::showReturnCode('', 1001, '缺少参数');
        if ($this->data['status'] == 1) {
            (new AskHelpValidate())->goCheck('deal');
        } elseif ($this->data['status'] == 2) {
            (new AskHelpValidate())->goCheck('over');
        } elseif ($this->data['status'] == 3) {
            (new AskHelpValidate())->goCheck('addvise');
        } else {
            self::showReturnCode('', 1001, '状态有误');
        }
        $res = (new AskHelpService())->updateHelp($this->data, $this->user);
        if ($res) {
            self::showReturnCode($res, 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }

    /**
     * Notes:火眼金睛+劳苦功高
     * User: myrxl
     * Date: 2019/8/26
     * Time: 8:46
     */
    public function ranking()
    {
        $type1 = input('post.type1', 'hyjj');//区别是火眼金睛还是劳苦功高 hyjj lkgg
        $type2 = input('post.type2', 'person');//区别是个人还是门店 person mall
        $res   = (new AskHelpService())->ranking($type1, $type2, $this->user);
        if ($res) {
            self::showReturnCode($res, 0, 'ok');
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }



}