<?php
namespace app\api\validate;
class MarketValidate extends BaseValidate{
    protected $rule = [
        'id|id'                           => 'require|number|max:10',
        'project_name|市调项目名称'             => 'require|max:255',
        'developer|开发商'                   => 'max:255',
        'start|开业时间'                      => 'date',
        'address|地址'                      => 'max:255',
        'area|经营面积'                       => 'max:100',
        'floor|商业楼层'                      => 'max:100',
        'level|档次定位'                      => 'max:100',
        'parking_num|停车位数量'               => 'number|max:11',
        'constmer_num|经营商户数量'             => 'number|max:11',
        'rent|租金情况及形式'                    => 'max:255',
        'service_pic|顾客服务亮点图片'            => 'max:2000',
        'service_explanation|顾客服务亮点说明'    => 'max:2000',
        'enviroment_pic|空间环境亮点图片'         => 'max:2000',
        'enviroment_explanation|空间环境亮点说明' => 'max:2000',
        'enlighten|启发与借鉴'                 => 'max:2000',
    ];

    //场景验证
    protected $scene = [
        'add' => ['project_name', 'developer', 'start', 'address', 'area', 'floor', 'level', 'parking_num', 'constmer_num', 'rent', 'service_pic', 'service_explanation', 'service_explanation', 'enviroment_pic', 'enviroment_explanation', 'enlighten'],
        'detail'=>['id']
    ];



}