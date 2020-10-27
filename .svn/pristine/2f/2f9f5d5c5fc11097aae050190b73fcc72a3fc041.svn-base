<?php
namespace app\api\controller\web;
use \think\Db;
use think\facade\Session;
use think\Controller;
class Login extends Controller
{
    public function index(){
        return view();
    }

    /**
     * Notes: 验证登录
     * User: myrxl
     * Date: 2019/9/5
     * Time: 13:55
     */
    public function checkLogin()
    {
        $name     = input('post.name', '');
        $password = input('post.password', '');
        if ($name == '' || $password == '') {
            return json(['code' => 1001, 'msg' => '参数错误', 'data' => '']);
        }
        $map = [
            'name'     => $name,
            'password' => MD5(MD5($password . '+10086')),
            'enabled'  => 1,
        ];
        $res = Db::name('admin')->where($map)->find();
        if ($res) {
            Session::set('admin', $res);
            return json(['code' => 0, 'msg' => '登录成功', 'data' => '']);
        } else {
            return json(['code' => 1002, 'msg' => '登录失败', 'data' => '']);
        }
    }

}