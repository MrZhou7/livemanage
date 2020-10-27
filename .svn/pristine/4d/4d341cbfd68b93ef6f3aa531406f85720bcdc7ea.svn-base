<?php

namespace app\api\controller\mini;

use app\api\validate\MarketValidate;
use app\service\controller\MarketService;
use think\App;

class Market extends BaseFunction
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->MarketService = new MarketService();
    }

    /**
     * Notes: 添加事项记录
     * User: myrxl
     * Date: 2019/8/26
     * Time: 15:09
     */
    public function add()
    {
        (new MarketValidate())->goCheck('add');
        $this->data['center_id'] = (new Interview())->checkCenterIsSet();
        $res                     = $this->MarketService->add($this->data);
        if (!$res) self::showReturnCode('', 1001, '参数有误');
        if ($res < 0) {
            self::showReturnCode('', 1001, '添加失败');
        } else {
            self::showReturnCode('', 0, 'ok');
        }
    }

    /**
     * Notes: 获取列表
     * User: myrxl
     * Date: 2019/8/27
     * Time: 8:35
     */
    public function getPageLists()
    {
        $page = getPage(input('post.'));
        $list = $this->MarketService->getPageLists($this->user['id'], $page);
        self::showReturnCode(['total' => $list->total(), 'list' => $list->items()], 0);
    }

    /**
     * Notes:获取详情
     * User: myrxl
     * Date: 2019/8/27
     * Time: 8:35
     */
    public function getDetail(){
        (new MarketValidate())->goCheck('detail');
        $data = $this->MarketService->getDetail($this->user['id'],$this->data['id']);
        self::showReturnCode($data, 0, 'ok');
    }
}