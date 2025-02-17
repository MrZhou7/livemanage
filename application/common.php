<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//httpGet请求
function httpGet($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}

/**上传图片，或多图片
 * @param $files 图片文件流，多图片则为数组
 * @param $n 多图片的个数限制
 * @return 图片url
 */
function image_upload($files, $path, $n = 5)
{
    $path = 'uploads/' . $path;
    if (!file_exists($path)) {
        @mkdir($path, 0777, true);
    }
    if (is_null($files)) return false;
    if (is_array($files)) {
        if (count($files) > $n) return false;
        $fileUrl = '';
        foreach ($files as $file) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info    = $file->validate(['ext' => 'jpg,png,jpeg,gif'])->move($path);
            $fileUrl .= ltrim($path, 'public') . $info->getSaveName() . '|';
        }
        $fileUrl = rtrim($fileUrl, '|');
        $url     = $fileUrl;
    } else {
        //单图片上传  移动到框架应用根目录/public/uploads/ 目录下
        $info = $files->validate(['ext' => 'jpg,png,jpeg'])->move($path);
        if (!$info) return false;
        $image = str_replace("\\", "/", $info->getSaveName());
        $url   = $path . '/' . $image;
    }
    return $url;
}

/**
 * 对象 转 数组
 * @param object $obj 对象
 * @return array
 */
function objectToArray($obj)
{
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)objectToArray($v);
        }
    }
    return $obj;
}

//获取page
function getPage($arr)
{
    $data = [];
    if (isset($arr['page'])) {
        $data['page'] = !empty($arr['page']) ? $arr['page'] : 1;
    } else {
        $data['page'] = 1;
    }
    if (isset($arr['limit'])) {
        $data['limit'] = !empty($arr['limit']) ? $arr['limit'] : 20;
    } else {
        $data['limit'] = 20;
    }
    return $data;
}

/**
 * 将数据集格式化成层次结构
 * @param array/object $lists 要格式化的数据集，可以是数组，也可以是对象
 * @param int $pid 父级id
 * @param int $max_level 最多返回多少层，0为不限制
 * @param int $curr_level 当前层数
 * @return array
 */
function toLayer($lists = [], $pid = 0, $max_level = 0, $curr_level = 0)
{
    $trees = [];
    $lists = array_values($lists);
    foreach ($lists as $key => $value) {
        if ($value['pid'] == $pid) {
            if ($max_level > 0 && $curr_level == $max_level) {
                return $trees;
            }
            unset($lists[$key]);
            $child = toLayer($lists, $value['id'], $max_level, $curr_level + 1);
            if (!empty($child)) {
                $value['child'] = $child;
            }
            $trees[] = $value;
        }
    }

    return $trees;
}

function find_createtime($day, $field = 'create_time')
{
    if ($day == 1) {
        //查询当天数据
        $today = strtotime(date('Y-m-d 00:00:00'));
        $data  = array($field, 'egt', $today);
        return $data;
    } else if ($day == 2) {
        //查询本周数据
        $arr   = getdate();
        $num   = $arr['wday'];
        $start = date('Y-m-d H:i:s', (time() - ($num - 1) * 24 * 60 * 60));
        $end   = date('Y-m-d H:i:s', (time() + (7 - $num) * 24 * 60 * 60));
        $data  = array($field, 'between', array($start, $end));
        return $data;
    } else if ($day == 3) {
        //查询本月数据
        $start = date('Y-m-01 00:00:00');
        $end   = date('Y-m-d H:i:s');
        $data  = array($field, 'between', array($start, $end));
        return $data;
    } else if ($day == 4) {
        //查询本季度数据
        $month = date('m');
        if ($month == 1 || $month == 2 || $month == 3) {
            $start = date('Y-01-01 00:00:00');
            $end   = date("Y-03-31 23:59:59");
        } elseif ($month == 4 || $month == 5 || $month == 6) {
            $start = date('Y-04-01 00:00:00');
            $end   = date("Y-06-30 23:59:59");
        } elseif ($month == 7 || $month == 8 || $month == 9) {
            $start = date('Y-07-01 00:00:00');
            $end   = date("Y-09-30 23:59:59");
        } else {
            $start = date('Y-10-01 00:00:00');
            $end   = date("Y-12-31 23:59:59");
        }
        $data = array($field, 'between', array($start, $end));
        return $data;
    } else if ($day == 5) {
        //查询本年度数据
        $year = date('Y-01-01 00:00:00');
        $data = array($field, 'egt', $year);
        return $data;
    }
}

/**
 * Notes:获取指定时间的本月起止时间
 * User: myrxl
 * @param $date
 * @return mixed
 * Date: 2020/10/19
 * Time: 14:30
 */
function currentMonth($date)
{
    $time          = strtotime($date);
    $info['start'] = date('Y-m-1 00:00:00', $time);
    $mdays         = date('t', $time);
    $info['end']   = date('Y-m-' . $mdays . ' 23:59:59', $time);
    return $info;
}

function Sec2Time($time)
{
    if (is_numeric($time)) {
        $value = array(
            "years"   => 0, "days" => 0, "hours" => 0,
            "minutes" => 0, "seconds" => 0,
        );
        if ($time >= 31556926) {
            $value["years"] = floor($time / 31556926);
            $time           = ($time % 31556926);
        }
        if ($time >= 86400) {
            $value["days"] = floor($time / 86400);
            $time          = ($time % 86400);
        }
        if ($time >= 3600) {
            $value["hours"] = floor($time / 3600);
            $time           = ($time % 3600);
        }
        if ($time >= 60) {
            $value["minutes"] = floor($time / 60);
            $time             = ($time % 60);
        }
        $value["seconds"] = floor($time);
        //return (array) $value;
        $t = $value["years"] . "年" . $value["days"] . "天" . " " . $value["hours"] . "小时" . $value["minutes"] . "分" . $value["seconds"] . "秒";
        Return $t;

    } else {
        return (bool)FALSE;
    }
}

/**
 * 判断当前的时分是否在指定的时间段内
 * @param $start 开始时分  eg:10:30
 * @param $end  结束时分   eg:15:30
 * @return: bool  1：在范围内，0:没在范围内
 * @author:rxl
 * @date:2019/10/14 10:46
 */
function checkIsBetweenTime($start, $end)
{
    $date        = date('H:i');
    $curTime     = strtotime($date);//当前时分
    $assignTime1 = strtotime($start);//获得指定分钟时间戳，00:00
    $assignTime2 = strtotime($end);//获得指定分钟时间戳，01:00
    $result      = false;
    if ($curTime > $assignTime1 && $curTime < $assignTime2) {
        $result = true;
    }
    return $result;
}
