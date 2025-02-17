<?php

namespace app\service\controller;

use app\model\User;
use app\model\OA;
use think\App;

class UserService extends BaseService
{
    public function __construct(App $app = null)
    {
        $this->UserModel = new User();
        $this->OAModel   = new OA();
    }


    /**
     * Notes: 验证员工是否有权限
     * User: myrxl
     * Date: 2019/10/15
     * Time: 15:37
     */
    public function getManager($id)
    {
        //通过员工id获取员工信息 - 工号
        $userInfo = $this->UserModel->getUserInfoById($id);
        //获取区域主管信息  商管部长
        $area   = $this->OAModel->getArea($userInfo['area_id']);
        $areaId = array_column($area, 'loginid');
        //获取门店经理信息  商管经理
        $mall   = $this->OAModel->getMall($userInfo['mall_id']);
        $mallId = array_column($mall, 'loginid');
        //获取总部商管
        $zb      = $this->OAModel->getzb();
        $zbId    = array_column($zb, 'loginid');
        $loginid = array_filter(array_merge($areaId, $mallId, $zbId));
//        //通过工号获取员工所有上级
//        $userOaInfo = $this->OAModel->getOAStatus($userInfo['gh']);
//        //获取上级 id 数组
//        $managerArr = array_unique(array_filter(explode(',', $userOaInfo['managerstr'])));
//        //获取上级信息
//        $managerInfo = $this->OAModel->getManager($managerArr);
//        $loginid     = array_column($managerInfo, 'loginid');
        return $loginid;
    }


    /**
     * 实时获取
     * Notes:通过oa获取用户的角色  中心商管权限  区域商管部长权限  门店商管经理权限  普通用户权限
     *       以后部门属性需要实时获取 也可以用这个接口扩展
     * User: myrxl
     * Date: 2019/10/14
     * Time: 10:57
     */
    public function getUserRoleByOa($openid)
    {
        $info = $this->getUserInfo($openid);
        //岗位层级：0-总裁级 1-总监级 2-部长级 3-高级经理级 4-经理级 5-主管级 6-员工级（普通员工） 7-员工级（一线员工）
        //部门属性：0-商业控股集团 1-区域本部 2-直营商场 3-加盟商场
        $data = (new OA())->getUserInfoFormOA($info['gh']);
        //$data         = (new OA())->getUserInfoFormOA('251110');
        $data['role'] = '0'; //默认0没有权限  1-商控商管 2-区域部长 3-商场经理
        if ($data['bmsx'] == 2 || $data['bmsx'] == 3) { //商场
            if ('商管部' === $data['ejbmwb'] && ('3' == $data['gwcji'] || '4' == $data['gwcji'])) { //商场经理
                $data['role'] = 3;
            }
            if ('总经办' === $data['ejbmwb']) { //门店总经办（新增需求-门店运营部长）
                $data['role'] = 3;
            }
        }
//        if ($data['bmsx'] == 2 || $data['bmsx'] == 3) { //商场
//            if ('商管部' === $data['sjbmwb'] && ('3' == $data['gwcji'] || '4' == $data['gwcji'])) { //商场经理
//                $data['role'] = 3;
//            }
//            if ('总经办' === $data['sjbmwb']) { //门店总经办（新增需求-门店运营部长）
//                $data['role'] = 3;
//            }
//        }
//        elseif ($data['bmsx'] == 1) { //区域
//            if ('商管部' === $data['ejbmwb'] && ('2' == $data['gwcji'] || '3' == $data['gwcji'] || '4' == $data['gwcji'])) { //区域部长
//                $data['role'] = 2;
//            }
//        }
        else { //商控
            if ('营运管理中心' === $data['yjbmwb'] && '商场管理部' == $data['ejbmwb']) { //商控商管
                $data['role'] = 1;
            }
        }


//        //商控-更新部门属性
//        if($data['role'] == 1){
//            $map = [
//                ['bmsx']
//            ];
//        }else{
//
//        }
//        //门店 更新所有信息
//
//
//        $userInfo = $this->UserModel->updateUserInfoById($id);


        $data = [
            'role' => $data['role'],
            'bmsx' => $data['bmsx'],
        ];
        return $data;
    }

    public function getUserInfo($openid)
    {
        $res = $this->UserModel->getUserInfo($openid);
        if ($res) {
            if (!$this->getOAStatus($res['gh'])) return 'Enabled';
        }
        return $res;
    }

    public function bindOA($data)
    {
        //验证工号 和 密码 是否匹配OA
        $OAUserInfo = self::checkOA($data['gh'], $data['password']);
        if (!$OAUserInfo) return 'checkError';
        if (!(in_array($OAUserInfo['status'], [0, 1, 2, 3]))) return 'Enabled';
        $user = $this->UserModel->checkUser($data['openid'], $data['gh']);
        if ($user) return 'REPEAT';
        //绑定用户信息
        $dataInfo = [
            'openid' => $data['openid'],
            'gh'     => $data['gh'],
            'name'   => $OAUserInfo['lastname'],
            'gender' => $OAUserInfo['sex'],
        ];
        $res      = $this->UserModel->bindWechat($dataInfo);
        if (($res === -1) || (!$res)) return 'REPEAT';
        return 'SUCCESS';
    }

    public function getOAStatus($gh)
    {
        //调取oa查看当前用户是否有效
        $OA = $this->OAModel->getOAStatus($gh);
        if (in_array($OA['status'], [0, 1, 2, 3])) {
            //有效
            return true;
        } else {
            //无效
            return false;
        }
    }


    public function getUserArea($gh)
    {
        //yghmc表中获取用户信息
        $data = (new OA())->getUserInfoFormOA($gh);
        //0商控 1区域本部 2直营商场 3加盟商场
        if ($data['bmsx'] == 2 || $data['bmsx'] == 3) {
            //查询所属区域 所属商场
            $mall_id = $data['fb'];//二级部门
            $mall    = (new OA())->getCompanyName($mall_id);
            $area_id = $mall['supsubcomid'];//一级部门
            $area    = (new OA())->getCompanyName($area_id);
            //10.16新增
            if (false !== strpos($area['subcompanyname'], '省') || false !== strpos($area['subcompanyname'], '自治区')) {
                $dataInfo = [
                    'area_id'     => 40,
                    'area'        => "委托经营商场",
                    'mall_id'     => $mall['id'],
                    'mall'        => $mall['subcompanyname'],
                    'province'    => $area['subcompanyname'],
                    'province_id' => $area['id'],
                    'bmsx'        => $data['bmsx']
                ];
            } else {
                //10.16新增end
                $dataInfo = [
                    'area_id' => $area['id'],
                    'mall_id' => $mall['id'],
                    'area'    => $area['subcompanyname'],
                    'mall'    => $mall['subcompanyname'],
                    'bmsx'    => $data['bmsx']
                ];
            }


        } elseif ($data['bmsx'] == 1) {
            //查询所属区域
            $area_id  = $data['fb'];//一级部门
            $area     = (new OA())->getCompanyName($area_id);
            $dataInfo = [
                'area_id' => $area['id'],
                'mall_id' => 0,
                'area'    => $area['subcompanyname'],
                'mall'    => '',
                'bmsx'    => $data['bmsx']
            ];
        } else {
            //不查  不属于上面的两种情况
            $dataInfo = [
                'area_id' => 0,
                'mall_id' => 0,
                'area'    => '',
                'mall'    => '',
                'bmsx'    => 0
            ];
        }
        $dataInfo['gh'] = $gh;
        //把用户的部门属性存入数据库
        $this->UserModel->bindMall(['bmsx' => $dataInfo['bmsx'], 'gh' => $dataInfo['gh']]);
        return $dataInfo;
    }

//    public function bindMall($data)
//    {
//        $dataInfo = $this->getUserArea($data['gh']);
//        if ($dataInfo['bmsx'] == 0) {
//            $dataInfo = $data;
//        } elseif ($dataInfo['bmsx'] == 1) {
//            $dataInfo['mall_id'] = $data['mall_id'];
//            $dataInfo['mall']    = $data['mall'];
//        }
//        //修改用户 对应的门店信息
//        return $this->UserModel->bindMall($dataInfo);
//    }

    //2019.11.01  新需求  区域管理也可以对区域进行切换  用于对委托商场的管理
    public function bindMall($data)
    {
        //修改用户 对应的门店信息
        return $this->UserModel->bindMall($data);
    }

    /*
     *验证工号 和 密码 是否匹配
     */
    public static function checkOA($gh, $password)
    {
        return (new OA())->checkOA($gh, $password);
    }

    public function getAllAreaList()
    {
        return (new OA())->getAllAreaList();
    }

    //正常接口
    public function getMallListByAreaId($id)
    {
        return (new OA())->getMallListByAreaId(explode(',', $id));
    }

    //非正常接口   针对区域人员设计的    区域要看到门店委托的信息
    public function getJoinMallListByAreaId($id)
    {
        //区域下的直营店 $id
        //区域下的加盟店 查询加盟店的id
        //1,通过id查询到区域名称 2,查询加盟店的id
        $area = $this->getAreaInfoById($id);
        if (!strstr($area['subcompanyname'], '委托经营商场')) {
            $join = $this->getJoinAreaInfoByName($area['subcompanyname']);
            $id   = isset($join['id']) ? [$id, $join['id']] : [$id];
        } else {
            $id = [$id];
        }
        return (new OA())->getMallListByAreaId($id);
    }


    public function getAreaInfoById($id)
    {
        return $this->OAModel->getAreaInfoById($id);
    }

    public function getJoinAreaInfoByName($name)
    {
        return $this->OAModel->getJoinAreaInfoByName($name);
    }

    public function getUserListByMallId($id)
    {
        return $this->UserModel->getUserListByMallId($id);
    }

    public function getUserList($data, $page)
    {
        return $this->UserModel->getUserList($data, $page);
    }

    public function sceneList($data, $userId)
    {
        return $this->UserModel->sceneList($data, $userId);
    }

    public function getUserInfoById($id)
    {
        return $this->UserModel->getUserInfoById($id);
    }

    /**
     * Notes:通过id 获取用户姓名
     * User: myrxl
     * @param $id
     * @return array|bool
     * Date: 2020/10/15
     * Time: 14:13
     */
    public function getUserNameList($id)
    {
        return $this->UserModel->getList("name", [["id", "in", $id]]);
    }

    /**
     * Notes:通过类型获取门店列表
     * User: myrxl
     * Date: 2020/10/16
     * Time: 8:56
     */
    public function getMallListByType($id)
    {
        $list = (new OA())->getMallListByAreaId(explode(',', $id));
        $data = [];
        foreach ($list as $k => $v) {
            if (false !== strpos($v['subcompanyname'], '省') || false !== strpos($v['subcompanyname'], '自治区')) {
                $provice[] = $v['id'];
            } else {
                $data[] = $v;
            }
        }
        $proviceList = [];
        if (!empty($provice)) {
            $proviceList = (new OA())->getMallListByAreaId($provice);
        }


        //halt($proviceList);
        $newData = array_merge($data, json_decode(json_encode($proviceList), true));
        return $newData;

    }


}
