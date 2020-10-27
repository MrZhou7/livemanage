<?php
namespace app\api\validate;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     */
    public function goCheck($func = '')
    {
        //必须设置content-type:application/json
        $request = request();
        $params  = $request->param();
        if (!$this->scene($func)->check($params)) {
            $code = 1000;
            $msg  = is_array($this->error) ? implode(';', $this->error) : $this->error;
            $data = (object)[];
            exit(json_encode(compact('code', 'msg', 'data')));
        }
        return ['code' => 0];
    }
}
