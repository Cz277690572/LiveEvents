<?php
namespace app\index\controller;

use app\common\lib\ali\Sms;

class Index
{
    public function index()
    {
        return '';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }

    public function sendSms()
    {
        try{
            $result = Sms::sendSms(15220501265, 123456);
            return json_encode($result);
        }catch (\Exception $e){
            echo $e;
        }
    }
}
