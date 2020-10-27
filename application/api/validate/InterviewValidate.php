<?php
namespace app\api\validate;
class InterviewValidate extends BaseValidate{
    protected $rule = [
        'customer_name|商户名称'     => 'require|max:100',
        'people|被访谈人'            => 'require|max:100',
        'position|被访谈人职位'        => 'require|max:100',
        'advice|商户意见及建议'         => 'require|max:255',
        'business_advice|商户经营建议' => 'require|max:255',
    ];

}