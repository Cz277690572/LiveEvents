<?php

namespace app\wap\controller;

use app\common\lib\Tools;

/**
 * 聊天室功能
 * Class chat
 * @package app\wap\controller
 * @author 伟彬 <277690572@qq.com>
 * @date: 2019/3/8 12:04
 */
class Chat
{
    public function index()
    {
        if(empty($_POST['game_id'])){
            return Tools::error('场次id不能为空');
        }
        if(empty($_POST['content'])){
            return Tools::error('n内容不能为空！');
        }

        $data['content'] = $_POST['content'];
        foreach ($_POST['http_server']->ports[1]->connections as $fd){
            $data['author']  = "用户$fd";
            $_POST['http_server']->push($fd, json_encode($data));
        }
        return Tools::success('发射成功！');
    }
}