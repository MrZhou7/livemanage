<?php
namespace app\api\validate;
class AfternoonTourValidate extends BaseValidate{
    protected $rule = [
        'channel_pic|主通道照片' => 'require|max:255',
        'toilet_pic|卫生间照片' => 'require|max:255',
        'focus_pic|重点商户照片' => 'require|max:255',
//        'pic|晨会问题记录照片' => 'max:255',
//        'problem|问题说明' => 'max:255',
    ];

}