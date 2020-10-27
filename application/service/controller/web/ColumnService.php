<?php
namespace app\service\controller\web;
use app\service\controller\BaseService;
use app\model\Column;
use think\App;
class ColumnService extends BaseService
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ColumnModel = new Column();
    }

    public function add($data)
    {
        $info          = $this->getInfo($data['pid']);
        $data['level'] = $info['level'] + 1;
        return $this->ColumnModel->add($data);
    }


    public function lists(){
        $list = $this->ColumnModel->lists();
        return toLayer($list,0,0,0);
    }

    public function getInfo($id)
    {
        $data = $this->ColumnModel->getInfo($id);
        return $data;
    }

    public function edit($data){
        $res = $this->ColumnModel->edit($data);
        return $res;
    }



}
