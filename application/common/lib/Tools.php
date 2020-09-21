<?php
namespace app\common\lib;
/**
 * 工具服务类
 * Class Tools
 * @author 伟彬 <277690572@qq.com>
 * @date: 2018/11/12 17:34
 */
class Tools
{
    public static function success($msg="success", $data=[], $code=1)
    {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data];
        return json_encode($result);
    }

    public static function error($msg="error", $data=[], $code=0)
    {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data];
        return json_encode($result);
    }

    public static function  object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }
        return $obj;
    }
}