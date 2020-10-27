<?php
namespace app\api\validate;
class AskHelpValidate extends BaseValidate{
    protected $rule = [
        'id|id'         => 'require|max:10',
        'floor|楼层'         => 'require|max:50',
        'area|区域'          => 'max:255',
        //'problem|问题说明'     => 'require',
        //'voice|语音说明'       => 'require',
        'problem_pic|问题照片'   => 'require|max:255',
        'solve_pic|处理照片'   => 'require|max:255',
        'status|状态'        => 'require',
        'improvement|改进内容' => 'require',
        'emergency|是否紧急'     => 'require|number|max:1',
    ];

    //场景验证
    protected $scene = [
        'add'       => ['floor', 'area', 'problem_pic'],
        'getDetail' => ['id'],
        'deal'      => ['id', 'solve_pic'],
        'addvise'   => ['id', 'improvement'],
        'over'      => ['id'],
        'getList'   => ['status'],
    ];
}