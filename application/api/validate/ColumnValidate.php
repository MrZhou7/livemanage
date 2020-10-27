<?php
namespace app\api\validate;
class ColumnValidate extends BaseValidate{
    protected $rule = [
        'id|id'   => 'require|number|max:11',
        'name|栏目名称'   => 'require|max:100',
        'pid|父级id' => 'require|number|max:11',
        'sort|排序'     => 'require|number|max:11',
    ];
    //场景验证
    protected $scene = [
        'add'    => ['name','parent','level','sort'],
        'getInfo' => ['id'],
        'edit' => ['id'],
    ];

}