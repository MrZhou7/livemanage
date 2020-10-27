<?php

namespace app\api\validate;
class AdviceValidate extends BaseValidate
{
    protected $rule = [
        'id|id'     => 'require|number|max:10',
        'advice|建议' => 'require',
    ];

    //场景验证
    protected $scene = [
        'add'    => ['advice'],
        'detail' => ['id']
    ];
}