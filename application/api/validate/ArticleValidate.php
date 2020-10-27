<?php
namespace app\api\validate;
class ArticleValidate extends BaseValidate{
    protected $rule = [
        'id|id'        => 'require|number|max:11',
        'title|标题'     => 'require|max:100',
        'content|内容'   => 'require',
        'column|分类'    => 'require|number|max:11',
        'sort|排序'      => 'number|max:11',
        'hot|是否置顶'     => 'number|max:1',
        'enabled|是否有效' => 'require|number|max:1',
    ];
    //场景验证
    protected $scene = [
        'add'    => ['title','content','column','sort','hot'],
        'getInfo' => ['id'],
        'edit' => ['id'],
    ];

}