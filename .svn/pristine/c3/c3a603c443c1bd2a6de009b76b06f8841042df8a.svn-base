<?php

namespace app\api\validate;
class CleanAssessmentValidate extends BaseValidate
{
    protected $rule = [
        'id|id'            => 'require|number|max:10',
        'pic|照片'           => 'require',
        'should_num|应到人数'  => 'require|number',
        'arrived_num|实到人数' => 'require|number',
        'type|类型'          => 'require|number'
    ];

    //场景验证
    protected $scene = [
        'add'    => ['pic', 'should_num', 'arrived_num', 'type'],
        'edit'   => ['id', 'pic', 'should_num', 'arrived_num', 'type'],
        'detail' => ['id']
    ];
}
