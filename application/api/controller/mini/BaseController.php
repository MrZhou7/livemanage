<?php

namespace app\api\controller\mini;

use think\App;
use think\Controller;
use app\service\controller\WechatService;
use think\Db;

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
 * errcode 1500 权限异常
 */
class BaseController extends Controller
{
    protected $openid;
    protected $date;
    protected $data;

    public function __construct(App $app = null)
    {

        parent::__construct($app);
        $this->isPost();
        $this->checkSeeionKey();
        //保存日志
        $this->saveLog();
    }

    /*是否为POST请求*/
    private function isPost()
    {
        if (request()->method() != "POST") self::showReturnCode('', 1000, '请求方式错误');

        $data = input('post.');
        unset($data['session_key']);
        $this->date = input('post.date', '');
        if ($this->date == '') $this->date = date('Y-m-d', time());
        $this->data = $data;
    }

    //保存请求日志
    public function saveLog()
    {
        $data = [
            'module'     => request()->module(),
            'controller' => request()->controller(),
            'action'     => request()->action(),
            'param'      => json_encode(request()->param()),
            'openid'     => $this->openid,
            'ip'         => request()->ip(),
            'error'      => ""
        ];
        DB::name('log')->insertGetId($data);
    }

    /**
     * Notes:验证SessionKey
     * User: myrxl
     * Date: 2019/8/19
     * Time: 20:10
     */
    public function checkSeeionKey()
    {
        $SeeionKey = input('post.session_key', '');
        if (!$SeeionKey) self::showReturnCode('', 1000, 'SeeionKey参数有误');
        $res = (new WechatService())->getSessionInfo($SeeionKey);
        if (!$res) {
            self::showReturnCode($res, 1000, 'SeeionKey验证失败');
        } else {
            $this->openid = $res['openid'];
        }
    }

    //返回参数 data 为对象
    public static function showReturnCode($data = '', $code = 0, $msg = 'ok')
    {
        if (empty($data) && !is_array($data)) $data = (object)[];
        exit(json_encode(compact('code', 'msg', 'data')));
    }
}
