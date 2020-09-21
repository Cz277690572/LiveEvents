<?php
/**
 * 同步的redis,单例模式
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/16 0016
 * Time: 下午 23:29
 */
namespace app\common\lib\redis;
class Predis
{
    public $redis = '';
    /**
     * 定义单例模式的变量
     * @var null
     */
    private static $_instance = null;

    /**
     * @return null
     * @throws \Exception
     */
    public static function getInstance()
    {
        if(empty(self::$_instance)){
            self::$_instance = new self();
            return self::$_instance;
        }else{
            return self::$_instance;
        }
    }

    public function __construct()
    {
        $this->redis = new \Redis(); // new \Swoole\Coroutine\Redis();

        $result = $this->redis->connect(config('redis.host'),
            config('redis.port'),config('redis.timeOut'));
        if($result === false){
            throw new \Exception('redis connect error');
        }
    }

    /**
     * redis设置key值
     * @param $key
     * @param $value
     * @param int $time
     * @return bool|string
     */
    public function set($key, $value, $time = 0)
    {
        if(!$key){
            return '';
        }
        if(is_array($value)){
            $value = json_encode($value);
        }
        if (!$time){
            return $this->redis->set($key, $value);
        }
        return $this->redis->setex($key, $time, $value);
    }

    /**
     * redis获取key值
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->get($key);
    }

    /**
     * @return \Redis|string
     */
    public function delete($key)
    {
        if(!$key){
            return '';
        }
        return $this->redis->delete($key);
    }

    public function sAdd($key, $val){
        return $this->redis->sAdd($key, $val);
    }

    public function sMembers($key){
        return $this->redis->sMembers($key);
    }
}