<?php
namespace app\api\controller\web;
use app\api\validate\ColumnValidate;
use app\service\controller\web\ColumnService;
use think\App;

class Column extends BaseController
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->ColumnService = new ColumnService();
    }

    public function index(){
        $lists = $this->ColumnService->lists();
        $this->assign('list', $lists);
        return view();
    }

    //添加分类
    public function add(){
        (new ColumnValidate())->goCheck('add');
        $arr = input('post.');
        $res = $this->ColumnService->add($arr);
        if($res < 0){
          //  $this->error('新增失败');
            self::showReturnCode('',1001,'添加失败');
        }else{
           // $this->success('新增成功');
            self::showReturnCode($res,0);
        }
    }

    public function lists()
    {
        $lists = $this->ColumnService->lists();
        $this->assign('list', $lists);
        return view();
    }

    public function getInfo()
    {
        (new ColumnValidate())->goCheck('getInfo');
        $arr   = input();
        $data  = $this->ColumnService->getInfo(input('id'));
        $lists = $this->ColumnService->lists();
        $this->assign('list', $lists);
        $this->assign('data', $data);
        if ($arr['type'] == 'get') {
            return view();
        } else {
            return view('edit');
        }
    }

    public function edit(){
        (new ColumnValidate())->goCheck('edit');
        //$arr = input('post.');
        $arr = input();
        $res = $this->ColumnService->edit($arr);
        if(!$res){
            self::showReturnCode('',1001,'修改失败');
        }else{
            self::showReturnCode($res,0);
        }
    }

}