<?php

namespace app\api\controller\mini;

use app\api\validate\ArticleValidate;
use app\service\controller\web\ArticleService;
use think\App;

class Article extends BaseFunction
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ArticleService = new ArticleService();
    }


    /**
     * Notes: 获取公告列表
     * User: myrxl
     * Date: 2019/8/30
     * Time: 14:18
     */
    public function getNoticeList()
    {
        $arr  = input('post.');
        $list = $this->ArticleService->getNoticeList($arr);
        self::showReturnCode($list, 0);
    }

    /**
     * Notes: 获取制度列表
     * User: myrxl
     * Date: 2019/8/30
     * Time: 14:55
     */
    public function getRuleList()
    {
        $arr  = input('post.');
        $list = $this->ArticleService->getRuleList($arr);
        self::showReturnCode($list, 0);
    }

    /**
     * Notes: 获取详情
     * User: myrxl
     * Date: 2019/8/30
     * Time: 15:55
     */
    public function getInfo()
    {
        $id   = input('post.id');
        $data = $this->ArticleService->getInfo($id);
        self::showReturnCode($data, 0);
    }

}