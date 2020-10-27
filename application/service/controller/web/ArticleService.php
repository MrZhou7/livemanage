<?php

namespace app\service\controller\web;

use app\service\controller\BaseService;
use app\model\Article;
use think\App;
use think\facade\Request;

class ArticleService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ArticleModel = new Article();
    }

    public function add($data)
    {
        return $this->ArticleModel->add($data);
    }


    public function lists($arr)
    {
        $page = getPage($arr);
        $list = $this->ArticleModel->lists($arr, $page);
        return $list;
    }

    public function getInfo($id)
    {
        $data            = $this->ArticleModel->getInfo($id);
        $request         = Request::instance();
        $host            = $request->host();
        $http            = $request->server()['REQUEST_SCHEME'];
        $url             = $http .'://'. $host;
        $data['content'] = str_replace("/livemanage/public/", $url . "/livemanage/public/", $data['content']);
        return $data;
    }

    public function edit($data)
    {
        $res = $this->ArticleModel->edit($data);
        return $res;
    }

    public function getNoticeList($arr)
    {
        $list = $this->ArticleModel->getNoticeList($arr);
        return $list;
    }

    public function getRuleList($arr)
    {
        $list = $this->ArticleModel->getRuleList($arr);
        $data = [];
        foreach ($list as $k => $v) {
            $data[$v['cid']]['list'][] = $v;
            $data[$v['cid']]['name']   = $v['name'];
        }
        $data = array_values($data);
        return $data;
    }


}
