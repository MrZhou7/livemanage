<?php
namespace app\api\validate;
class MorningMeetingValidate extends BaseValidate{
    protected $rule = [
        'pic|照片'                   => 'require|max:255',
        'should_num|应到人数'          => 'require|number|max:11',
        'arrived_num|实到人数'         => 'require|number|max:11',
        'ask_customer|请假商户名'       => 'max:255',
        'absent_customer|无故缺席商户名'  => 'max:255',
        'nospec_customer|工装不规范商户名' => 'max:255',
    ];

}