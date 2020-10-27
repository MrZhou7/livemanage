<?php
namespace app\api\validate;
class SendValidate extends BaseValidate{
    protected $rule = [
        'pic|照片'                    => 'require|max:255',
        'violations_customer|违规商户名' => 'max:255',
    ];

}