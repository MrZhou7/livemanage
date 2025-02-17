<?php
namespace app\api\controller\mini;
use app\service\controller\UserService;
use app\api\validate\UserValidate;
use think\App;

class User extends BaseController
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->UserService = new UserService();
    }


    /**
     * Notes:获取用户信息
     * User: myrxl
     * Date: 2019/8/19
     * Time: 20:10
     */
    public function getUserInfo()
    {
        $data = $this->UserService->getUserInfo($this->openid);
        if(!$data) self::showReturnCode($data,'0','未绑定');
        if($data == 'Enabled'){
            self::showReturnCode('','1111','当前用户已被禁用');
        }else{
            self::showReturnCode($data,'0','ok');
        }
    }

    /**
     * Notes: 获取用户权限
     * User: myrxl
     * Date: 2019/10/14
     * Time: 15:08
     */
    public function getUserRoleByOa(){
        $data = $this->UserService->getUserRoleByOa($this->openid);
        self::showReturnCode($data,'0','ok');
    }


    /**
     * Notes: 绑定OA
     * User: myrxl
     * Date: 2019/8/20
     * Time: 9:29
     */
    public function bindOA()
    {
        (new UserValidate())->goCheck('bind');
        $data = $this->UserService->bindOA(input('post.'));
        if ($data != 'SUCCESS') {
            if ($data == 'checkError') $str = '账号密码不匹配';
            if ($data == 'REPEAT') $str = '微信或工号已绑定';
            if ($data == 'Enabled') $str = '账号已被禁用';
            self::showReturnCode('', '1000', $str);
        }
        self::showReturnCode($data, '0', 'ok');
    }

    /**
     * Notes:获取用户所在区域
     * User: myrxl
     * Date: 2019/8/20
     * Time: 10:53
     */
    public function getUserArea(){
        //(new UserValidate())->goCheck('getArea');
        $data = $this->UserService->getUserArea(input('post.gh'));
        self::showReturnCode($data, '0', 'ok');
    }


    /**
     * Notes: 获取所有的区域-列表
     * User: myrxl
     * Date: 2019/8/20
     * Time: 14:59
     */
    public function getAllAreaList(){
        $data = $this->UserService->getAllAreaList();
        self::showReturnCode($data, '0', 'ok');
    }

    /**
     * Notes: 根据区域-查询门店列表
     * User: myrxl
     * Date: 2019/8/20
     * Time: 15:01
     */
    public function getMallListByAreaId()
    {
        $id = input('post.id', '');
        if (!$id) self::showReturnCode('', '1000', '参数错误');
        $data = $this->UserService->getMallListByAreaId($id);
        self::showReturnCode($data, '0', 'ok');
    }

    /**
     * Notes: 通过选择直营或者委托商场查询对应的 门店信息
     * User: myrxl
     * Date: 2020/10/16
     * Time: 8:54
     */
    public function getMallListByType(){
        //直营或者委托  对应的id
        $id = input('post.id', '');
        if (!$id) self::showReturnCode('', '1000', '参数错误');
        $data = $this->UserService->getMallListByType($id);
        self::showReturnCode($data, '0', 'ok');
    }


    /**
     * Notes:新增接口  根据区域-查询门店列表（针对区域商管设计  可以查看对于委托商场的信息）
     * User: myrxl
     * Date: 2019/11/1
     * Time: 10:25
     */
    public function getJoinMallListByAreaId()
    {
        $id = input('post.id', '');
        if (!$id) self::showReturnCode('', '1000', '参数错误');
        $data = $this->UserService->getJoinMallListByAreaId($id);
        self::showReturnCode($data, '0', 'ok');
    }

    /**
     * Notes: 根据门店-查询员工列表
     * User: myrxl
     * Date: 2019/10/14
     * Time: 15:49
     */
    public function getUserListByMallId(){
        $id = input('post.id', '');
        if (!$id) self::showReturnCode('', '1000', '参数错误');
        $data = $this->UserService->getUserListByMallId($id);
        self::showReturnCode($data, '0', 'ok');
    }




    /**
     * Notes:修改绑定 用户区域
     * User: myrxl
     * Date: 2019/8/20
     * Time: 16:53
     */
    public function bindMall(){
        (new UserValidate())->goCheck('bindMall');
        $data = $this->UserService->bindMall(input());
        self::showReturnCode($data, '0', 'ok');
    }

    /**
     * Notes:上传图片接口
     * User: myrxl
     * Date: 2019/8/20
     * Time: 17:57
     */
    public function uploadImage()
    {
        $type = input('post.type', 'normal');
        $file = request()->file('image');
        $data = image_upload($file, $type);
        if (!$data) self::showReturnCode($data, '1000', '图片上传失败');
        self::showReturnCode($data, '0', 'ok');
    }
}
