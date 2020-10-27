<?php
namespace app\api\validate;
class UserValidate extends BaseValidate{
    protected $rule = [
        'openid|openid' => 'require',
        'gh|OA工号'       => 'require',
        'password|密码'   => 'require',
        'area_id|区域id'   => 'require',
        'mall_id|门店id'   => 'require',
        'area|区域'   => 'require',
        'mall|门店'   => 'require',

    ];

    //场景验证
    protected $scene = [
        'bind'      => ['openid', 'gh', 'password'],
        'getArea'   => ['gh'],
        'checkBind' => ['openid'],
        'bindMall' => ['gh','area_id','mall_id','area','mall'],
    ];
}