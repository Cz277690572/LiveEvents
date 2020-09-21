<?php
namespace app\admin\controller;
use app\common\lib\Tools;

/**
 * 图片上传
 * Class Image
 * @author 伟彬 <277690572@qq.com>
 * @date: 2019/3/5 15:02
 */
class Image
{
    public function index()
    {
        $file = request()->file('file');
        $info = $file->move('../public/static/upload');
        if($info) {
            $data = [
                'image' => config('live.host')."/static/upload/".$info->getSaveName(),
            ];
            return Tools::success('success', $data);
        }else {
            return Tools::error('error');
        }
    }
}