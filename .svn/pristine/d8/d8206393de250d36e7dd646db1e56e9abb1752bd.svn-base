<?php
namespace app\model;

class User extends BaseModel
{

    public function getUserInfo($openid){
        return $this->getBaseInfo('*',['openid'=>$openid]);
    }

    public function getUserInfoById($id){
        return $this->getBaseInfo('*',['id'=>$id]);
    }

    public function checkUser($openid,$gh){
        $map1 = ['openid'=>$openid];
        $map2 = ['gh'=>$gh];
        return $this->whereOr($map1)->whereOr($map2)->count();
    }
    public function bindWechat($dataInfo){
        return $this->baseSaveInfo($dataInfo);
    }

    public function bindMall($data)
    {
        return $this->baseSaveInfo($data, ['gh' => $data['gh']], 'edit');
    }

    public function getUserList($data, $page)
    {
        $field = '*';
        $map[] = ['a.enabled', '=', 1];
        $map[] = ['a.bmsx', 'in', [2, 3]];
        if(isset($data['area_id'])){
            if($data['area_id'] != ''){
                $map[] = ['a.area_id', '=', $data['area_id']];
            }
        }
        if(isset($data['mall_id'])){
            if($data['mall_id'] != ''){
                $map[] = ['a.mall_id', '=', $data['mall_id']];
            }
        }

        $order = "area_id desc mall_id desc id desc";
        $join  = [];
        return $this->getPageList($field, $map, $order, $join, $page['page'], $page['limit']);
    }


    public function sceneList($data, $userId)
    {
        // 时间
        $field = 'c.id,a.name,a.id a_user_id,a.mall,a.area';
        $map   = [];
        $map[] = ['a.id', 'in', $userId];
        $order = 'c.id desc';
//        $join  = [
//            ['center c', "a.id = c.user_id and c.enabled = 1 and c.is_morning_meeting = 1 and c.is_welcome = 1 and c.is_morning_tour = 1 and c.is_afternoon_tour = 1 and c.is_interview = 1 and c.is_send = 1 and c.date BETWEEN '{$data['start']}' and '{$data['start']}'", 'left'],
//        ];

        $join  = [
            ['center c', "a.id = c.user_id and c.enabled = 1 and c.is_morning_meeting = 1 and c.is_welcome = 1 and c.is_morning_tour = 1 and c.is_afternoon_tour = 1 and c.is_interview = 1 and c.is_send = 1 and c.date BETWEEN '{$data['start']}' and '{$data['end']}'", 'left'],
        ];
        return $this->getJoinList($field, $map, $join, $order);
    }

    public function getUserListByMallId($id)
    {
        $field = 'id,gh,name';
        $map[] = ['mall_id', '=', $id];
        $map[] = ['enabled', '=', 1];
        $map[] = ['bmsx', 'in', [2, 3]];
        $join  = [];
        $order = 'id desc';
        return $this->getJoinList($field, $map, $join, $order);
    }


}