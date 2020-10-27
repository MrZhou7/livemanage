<?php
namespace app\api\controller\web;
use think\App;
use think\Controller;
use think\Db;
use think\facade\Session;
//                            _ooOoo_
//                           o8888888o
//                           88" . "88
//                           (| -_- |)
//                            O\ = /O
//                        ____/`---'\____
//                      .   ' \\| |// `.
//                       / \\||| : |||// \
//                     / _||||| -:- |||||- \
//                       | | \\\ - /// | |
//                     | \_| ''\---/'' | |
//                      \ .-\__ `-` ___/-. /
//                   ___`. .' /--.--\ `. . __
//                ."" '< `.___\_<|>_/___.' >'"".
//               | | : `- \`.;`\ _ /`;.`/ - ` : | |
//                 \ \ `-. \_ __\ /__ _/ .-` / /
//         ======`-.____`-.___\_____/___.-`____.-'======
//                            `=---='
//
//         .............................................
//                  佛祖保佑             永无BUG

/**
 * errcode 0 请求成功
 * errcode 1000 Validate验证失败
 * errcode 1300 PDO数据库错误
 * errcode 1400 请求异常
 */
class BaseController extends Controller
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        //$this->saveLog();
    }

    //保存请求日志
    public function saveLog()
    {
        $data = Session::get('admin');
        //if(!$data) self::showReturnCode('请先登录',1008);
        if(!$data) {
            return $this->redirect('web/login/index');
            //return $this->error('新增失败','web/login/index');
        }
        $data = [
            'module'     => request()->module(),
            'controller' => request()->controller(),
            'action'     => request()->action(),
            'param'      => json_encode(request()->param()),
            //'openid'     => $this->openid,
            'openid'     => $data['name'],
            'ip'         => request()->ip(),
            'error'      => "",
        ];
        DB::name('log')->insertGetId($data);
    }
    /*是否为POST请求*/
    private function isPost(){
        if(request()->method()!="POST") self::showReturnCode('', 1000, '请求方式错误');
    }

    //返回参数 data 为对象
    public static function showReturnCode($data = '', $code = 0, $msg = 'ok')
    {
        if (empty($data) && !is_array($data)) $data = (object)[];
        exit(json_encode(compact('code', 'msg', 'data')));
    }
}
