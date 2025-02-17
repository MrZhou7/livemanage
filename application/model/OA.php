<?php

namespace app\model;

use think\Exception;

class OA extends BaseModel
{
    protected $connection = 'db_oa';

    public function checkOA($gh, $password)
    {
        $map = [
            'loginid'  => $gh,
            'password' => strtoupper(MD5($password)),
        ];
        return $this->table('HrmResource')->where($map)->find();
    }

    public function getUserInfoFormOA($gh)
    {
        $map = [
            'gh' => $gh,
        ];
        return $this->table('uf_yghmc')->where($map)->find();
    }

    public function getCompanyName($id)
    {
        return $this->table('HrmSubCompany')->where(['id' => $id])->find();
    }

//    public function getAllAreaList()
//    {
//        $map[]  = [
//            ['subcompanyname', 'like', '%区域%'],
//            ['canceled','in',[0,null]]
//        ];
//        $map2[] = [
//            ['subcompanyname', 'like', '%项目组%'],
//            ['canceled','in',[0,null]]
//        ];
//        return $this->table('HrmSubCompany')
//            ->whereOr($map)
//            ->whereOr($map2)
//            ->select();
//    }

    public function getAllAreaList()
    {
        $map[]  = [
            ['subcompanyname', 'in', ['直营商场','委托经营商场']],
            ['canceled', '=', 0],
        ];
        $map2[]  = [
            ['subcompanyname', 'in', ['直营商场','委托经营商场']],
            ['canceled', '=', null],
        ];

        return $this->table('HrmSubCompany')
              ->whereOr($map)
            ->whereOr($map2)
            ->order("id desc")
            ->select();
    }

    public function getMallListByAreaId($id)
    {
        $map[] = [
            ['supsubcomid', 'in', $id],
            ['canceled','=',0]
        ];
        $map2[] = [
            ['supsubcomid', 'in', $id],
            ['canceled','=',null]
        ];
        return $this->table('HrmSubCompany')
            ->whereOr($map)
            ->whereOr($map2)
            ->select();
    }


    public function getOAStatus($gh)
    {
        $map = [
            'loginid' => $gh,
        ];
        return $this->table('HrmResource')->where($map)->find();
    }

    public function getAreaInfoById($id){
        $map = [
            'id' => $id,
        ];
        return $this->table('HrmSubCompany')->where($map)->find();
    }

    public function getJoinAreaInfoByName($name){
        $map = [
            'subcompanyname' => $name.'委托经营商场',
        ];
        return $this->table('HrmSubCompany')->where($map)->find();
    }



    /**
     * Notes:通过区域id查找 商管部长+商管经理信息
     * User: myrxl
     * Date: 2019/10/16
     * Time: 18:00
     * @param $area_id
     */
    public function getArea($area_id)
    {
        $field = "a.*";
//        $map   = [
//            'a.subcompanyid1' => $area_id,
//            't.jobtitlename'  => '商管部长',
//        ];
        $map = [];
        $map[] = ['a.subcompanyid1','=',$area_id];
        $map[] = ['t.jobtitlename','in',['商管部长','商管经理']];
        $join  = [
            ['HrmJobTitles t', 'a.jobtitle = t.id'],
        ];
        return $this->table('HrmResource')->alias('a')->field($field)->where($map)->join($join)->select()->toArray();
    }

    /**
     * Notes:通过门店id查找 商管经理信息
     * User: myrxl
     * Date: 2019/10/16
     * Time: 18:00
     * @param $mall_id
     */
    public function getMall($mall_id)
    {
        $field = "a.*";
        $map   = [
            'a.subcompanyid1' => $mall_id,
            't.jobtitlename'  => '商管经理',
        ];
        $join  = [
            ['HrmJobTitles t', 'a.jobtitle = t.id'],
        ];
        return $this->table('HrmResource')->alias('a')->field($field)->where($map)->join($join)->select()->toArray();
    }

    //HrmDepartment 442
    public function getzb(){
        $field = "a.*";
        $map   = [
            'd.id' => 442,
        ];
        $join  = [
            ['HrmDepartment d', 'd.id = a.departmentid'],
        ];
        return $this->table('HrmResource')->alias('a')->field($field)->where($map)->join($join)->select()->toArray();
    }

    //获取上级 人员信息
    public function getManager($managerArr)
    {
        $map[] = ['id', 'in', $managerArr];
        return $this->table('HrmResource')->where($map)->select()->toArray();
    }


}
