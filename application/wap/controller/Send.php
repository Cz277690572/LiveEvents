<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/15 0015
 * Time: 下午 23:52
 */

namespace app\wap\controller;
use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\Tools;
class Send
{
    public function smsCode()
    {
        $phone = intval($_GET['phone_num']);//request()->get('phone_num',0, 'intval');
        if(!$phone){
            return Tools::error('参数不齐', [], config('code.parameter_error'));
        }
        $code = rand(1000, 9999);

        $taskData = [
            'method' => 'sendSmsCode',
            'data' => [
                'phone' => $phone,
                'code' => $code
            ]
        ];
        $_POST['http_server']->task($taskData);
        return Tools::success('获取手机验证码成功！', $taskData['data']);

//        try{
//            $response = Sms::sendSms($phone, $code);
//        } catch (\Exception $e){
//            return Tools::error('阿里大于内部异常！');
//        }
//        $data = Tools::object_to_array($response);
//        $response->Code = 'OK';
//        $data['smsCode'] = $code;
//        if($response->Code) {
//            同步操作redis
//            $redis = new \Swoole\Coroutine\Redis();
//            $redis->connect(config('redis.host'), config('redis.port'));
//            $redis->set(Redis::smsKey($phone), $code, config('redis.out_time'));
//            return Tools::success('获取手机验证码成功！', $data);
//        }else{
//            return Tools::error('获取手机验证码失败！');
//        }
    }
}