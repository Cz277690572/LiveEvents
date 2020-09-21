<?php

namespace app\wap\controller;
use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\redis\Predis;
use app\common\lib\Tools;
/**
 * 登录控制类
 * Class Login
 * @package app\index\controller
 * @author 伟彬 <277690572@qq.com>
 * @date: 2018/11/12 17:12
 */
class Login
{

    /**
     * 登录接口
     * @return false|string
     * @throws \Exception
     */
    public function index()
    {
        $phoneNum = intval($_GET['phone_num']);
        $code     = intval($_GET['code']);
        if(empty($phoneNum) || empty($code)){
            return Tools::error('参数不齐', [], config('code.parameter_error'));
        }
        try{
            $redisCode = Predis::getInstance()->get(Redis::smsKey($phoneNum));
        }catch (\Exception $e){
            return Tools::error('系统异常:'.$e->getMessage());
        }

        if($redisCode == $code){
            // 校验成功，写入redis
            $data = [
                'user' => $phoneNum,
                'srcKey' => md5(Redis::userKey($phoneNum)),
                'time' => time(),
                'isLogin' => true,
            ];
            Predis::getInstance()->delete(Redis::smsKey($phoneNum));
            Predis::getInstance()->set(Redis::userKey($phoneNum), serialize($data));
            return Tools::success('登录成功！', $data);
        }else{
            return Tools::error('验证码输入错误!');
        }
    }

    /**
     * 获取短信验证码
     * @return false|string
     */
    public function getSmsCode()
    {
        $phone = request()->get('phone_num',0, 'intval');
        if(!$phone){
            return Tools::error('参数不齐', [], config('code.parameter_error'));
        }
        $code = rand(1000, 9999);
//        try{
//            $response = Sms::sendSms($phone, $code);
//        } catch (\Exception $e){
//            return Tools::error('阿里大于内部异常！');
//        }
//        $data = Tools::object_to_array($response);
//        $response->Code = 'OK';
        $data = array('code' => $code);
        if(true) {
            $redis = new \Swoole\Coroutine\Redis();
            $redis->connect(config('redis.host'), config('redis.port'));
            $redis->set(Redis::smsKey($phone), $code, config('redis.out_time'));
            return Tools::success('获取手机验证码成功！', $data);
        }else{
            return Tools::error('获取手机验证码失败！');
        }
    }
}