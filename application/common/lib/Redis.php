<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26 0026
 * Time: 上午 0:10
 */

namespace app\common\lib;


class Redis
{
    /**
     * 验证码 redis key的前缀
     * @var string
     */
    public static $pre = "sms_";

    /**
     * 用户的前缀
     * @var string
     */
    public static $userPre = 'user_';

    /**
     * 存储验证码的key值
     * @param $phone
     * @return string
     */
    public static function smsKey($phone)
    {
        return self::$pre.$phone;
    }

    /**
     * 存储用户的key
     * @param $phone
     * @return string
     */
    public static function userKey($phone)
    {
        return self::$userPre.($phone);
    }
}