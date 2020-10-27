<?php
/**
 *
 *
 * @author: Administrator zengqinggui@zhuolipu.com
 * @date: 2018/11/08
 */

namespace app\common\exception;

use Exception;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\PDOException;
use think\exception\ValidateException;

class ErrorException extends Handle
{
    public function render(Exception $e)
    {
        // 参数验证错误
        if ($e instanceof ValidateException)
        {
            return json(['errcode' => '1000', 'errmsg' => $e->getError(), 'data' => ''], 200);
        }

        // 数据库错误
//        if ($e instanceof PDOException)
//        {
//            return json(['errcode' => '1300', 'errmsg' => "数据库错误", 'data' => ''], 200);
//        }
        if ($e instanceof PDOException)
        {
            return json(['errcode' => '1300', 'errmsg' => $e->getMessage(), 'data' => ''], 200);
        }

        // 请求异常
        if ($e instanceof HttpException)
        {
            return json(['errcode' => '1400', 'errmsg' => '请求异常', 'data' => ''], 200);
        }

        // 请求异常
        if ($e instanceof Exception || $e instanceof \think\Exception || $e instanceof \ErrorException)
        {
            return json(['errcode' => '1400', 'errmsg' => $e->getMessage(), 'data' => ''], 200);
        }

        //可以在此交由系统处理
        return parent::render($e);
    }
}
