<?php

namespace app\api\controller\mini;

use app\api\validate\AdviceValidate;
use app\service\controller\AdviceService;
use think\App;

class Advice extends BaseFunction
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->AdviceService = new AdviceService();
    }

    /**
     * Notes:添加建议
     * User: myrxl
     * Date: 2019/8/27
     * Time: 11:09
     * @throws \app\lib\exception\ParameterException
     */
    public function add()
    {
        (new AdviceValidate())->goCheck('add');
        $res = $this->AdviceService->add($this->data, $this->user);
        if ($res < 0) {
            self::showReturnCode('', 1001, '添加失败');
        } else {
            self::showReturnCode('', 0, 'ok');
        }
    }

    /**
     * Notes:获取列表
     * User: myrxl
     * Date: 2019/8/27
     * Time: 11:17
     */
    public function getPageLists()
    {
        $page = getPage(input('post.'));
        $list = $this->AdviceService->getPageLists($this->user['id'], $page);
        self::showReturnCode(['total' => $list->total(), 'list' => $list->items()], 0);
    }

    /**
     * Notes: 获取详情
     * User: myrxl
     * Date: 2019/8/27
     * Time: 11:17
     * @throws \app\lib\exception\ParameterException
     */
    public function getDetail()
    {
        (new AdviceValidate())->goCheck('detail');
        $data = $this->AdviceService->getDetail($this->user['id'], $this->data['id']);
        self::showReturnCode($data, 0, 'ok');

    }
}
