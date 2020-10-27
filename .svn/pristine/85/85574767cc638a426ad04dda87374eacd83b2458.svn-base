<?php
namespace app\api\validate;
class MatterRecordValidate extends BaseValidate{
    protected $rule = [
        'id|商户名称'            => 'require|number|max:10',
        'coustmer_name|商户名称' => 'require|max:255',
        'reasons|罚款事由'       => 'max:255',
        'money|罚款金额'         => 'max:255',
        'status|是否缴纳'        => 'number|max:1',
        'important|今日重要事件'   => 'max:255',
        'lightspot|服务亮点'     => 'max:255',
        'morrow|次日晨会宣讲内容记录'  => 'max:255',
        'work|明日是否正常上班'      => 'number|max:1',
    ];

    //场景验证
    protected $scene = [
        //'add' => ['coustmer_name', 'reasons', 'money', 'status', 'important', 'lightspot', 'morrow', 'work'],
    ];



}