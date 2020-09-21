<?php

namespace app\admin\controller;

use app\common\lib\Tools;

/**
 * Class Live
 * @package app\admin\controller
 * @author 伟彬 <277690572@qq.com>
 * @date: 2019/3/5 16:03
 */
class Live
{
    public function push()
    {
        if(empty($_GET)){
            return Tools::error('参数不能为空');
        }

        $teams = [
            1 => [
                'name' => '马刺',
                'logo' => '/live/imgs/team1.png',
            ],
            2 => [
                'name' => '火箭',
                'logo' => '/live/imgs/team2.png',
            ],
        ];

        $data = [
            'type' => intval($_GET['type']),
            'title' => !empty($teams[$_GET['team_id']]['name']) ? $teams[$_GET['team_id']]['name'] : '直播员',
            'logo' => !empty($teams[$_GET['team_id']]['logo']) ? $teams[$_GET['team_id']]['logo'] : '',
            'content' => !empty($_GET['content']) ? $_GET['content'] : '',
            'image' => !empty($_GET['image']) ? $_GET['image'] : '',
        ];

        $taskData = [
            'method' => 'pushLive',
            'data' => $data
        ];

        $_POST['http_server']->task($taskData);
        return Tools::success('发布成功！', $taskData);
    }

}