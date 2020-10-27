<?php
namespace app\api\validate;
class WechatValidate extends BaseValidate{
    protected $rule = [
        'js_code|js_code' => 'require',
        'session_key|session_key' => 'require',
        'encryptedData|encryptedData' => 'require',
        'iv|iv' => 'require',
    ];


    //场景验证
    protected $scene = [
        'decryptData' => ['session_key', 'encryptedData', 'iv'],
        'getSessionKey' => ['js_code'],
    ];

}