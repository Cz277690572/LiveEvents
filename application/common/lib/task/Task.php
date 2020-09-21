<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/16 0016
 * Time: 上午 0:53
 */
namespace app\common\lib\task;

use app\common\lib\ali\Sms;
use app\common\lib\Redis;
use app\common\lib\redis\Predis;
use app\common\lib\Tools;

class Task
{
    /**
     * 异步发送 验证码
     * @param $data
     * @param $serv
     * @return array
     * @throws \Exception
     */
    public function sendSmsCode($data, $serv)
    {
        $obj = new Sms();
        try{
            $response = $obj::sendSms($data['phone'], $data['code']);
        } catch (\Exception $e){
            // 将信息记录日志
            file_put_contents('/data/log/sms_send.log', '['.date('Ymd h:i:s').']: '.'短信接口类调用异常: '.$e->getMessage(),json_encode(array())."\n",FILE_APPEND);
            return array('status' => false, 'msg' => '短信接口类调用异常: '.$e->getMessage(), 'data' => array());
        }
        $smsSendRes = Tools::object_to_array($response);

        // 发送成功，将验证码记录到redis里面
        Predis::getInstance()->set(Redis::smsKey($data['phone']), $data['code'], config('redis.out_time'));
        file_put_contents('/data/log/sms_send.log', '['.date('Ymd h:i:s').']: '.'短信接口类调用成功! ',json_encode($smsSendRes)."\n",FILE_APPEND);
        return array('status' => true, 'msg' => '短信接口类调用成功！', 'data' => $smsSendRes);
    }

    /**
     * 通过task机制发送赛况实时数据给客户端
     * @param $data
     * @param $serv swoole server对象
     */
    public function pushLive($data, $serv){
        $clients = Predis::getInstance()->sMembers(config('redis.live_game_key'));

        foreach ($clients as $fd) {
            $serv->push($fd, json_encode($data));
        }
    }
}