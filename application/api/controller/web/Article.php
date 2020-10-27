<?php

namespace app\api\controller\web;

use app\service\controller\web\ArticleService;
use app\service\controller\web\ColumnService;
use app\api\validate\ArticleValidate;
use think\App;

class Article extends BaseController
{

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ArticleService = new ArticleService();
    }

    public function index()
    {
        $lists = (new ColumnService())->lists();
        $this->assign('list', $lists);
        return view();
    }

    public function add()
    {
        (new ArticleValidate())->goCheck('add');
        $res = $this->ArticleService->add(input('post.'));
        if ($res < 0) {
            self::showReturnCode('', 1001, '添加失败');
        } else {
            self::showReturnCode($res, 0);
        }
    }

    //获取文章列表
    public function lists()
    {
        $column = (new ColumnService())->lists();
        $list   = $this->ArticleService->lists(input());
        $page   = $list->render();
        $this->assign('page', $page);
        $this->assign('column_id', input('column'));
        $this->assign('list', $list);
        $this->assign('column', $column);
        return view();
    }

    //获取文章详情
    public function getInfo()
    {
        (new ArticleValidate())->goCheck('getInfo');
        $data = $this->ArticleService->getInfo(input());
        $this->assign('data', $data);
        return view('edit');
    }

    //修改接口
    public function edit()
    {
        (new ArticleValidate())->goCheck('edit');
        $res = $this->ArticleService->edit(input('post.'));
        if ($res) {
            self::showReturnCode($res, 0);
        } else {
            self::showReturnCode('', 1001, '保存失败');
        }
    }
}