<?php

/**
 * swoole--http服务
 * Class http
 * @author 伟彬 <277690572@qq.com>
 * @date: 2018/10/25 14:45
 */
class server_http
{
    public $serv;

    public function __construct()
    {
        $this->serv = new swoole_http_server("0.0.0.0", 9580);
        // 设置document_root并设置enable_static_handler为true后，底层收到Http请求会先判断document_root路径下是否存在此文件，如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
        // 设置了worker_num和task_worker_num超过1时，每个进程都会触发一次onWorkerStart事件，可通过判断$worker_id区分不同的工作进程
        // http://swoole.cn:9580/?s=index/index/index以兼容模式访问
        $this->serv->set([
            'document_root' => '/data/www/swoole/LiveEvents/public',
            'enable_static_handler' => true,
            'worker_num' => 5
        ]);

        $this->serv->on('WorkerStart', [$this, 'onWorkerStart']);

        $this->serv->on('request', [$this, 'onRequest']);
        $this->serv->start();
    }

    public function onWorkerStart($serv, $worker_id)
    {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');

        // 加载框架的基础文件
        require __DIR__ . '/../thinkphp/base.php';
    }

    public function onRequest($request, $response)
    {
        $_SERVER=[];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        // swoole对于define常量,GET、POST等超全局变量是不会释放的，比如上一次get只请求带参数name=mike,下次get请求只带参数age=1这是打印GET会有上一次的name=mike
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }

        ob_start();
        // 执行应用并响应
        try{
            think\Container::get('app', [APP_PATH])
                ->run()
                ->send();
        }catch (\Exception $e){
            echo $e;
        }
        $res = ob_get_contents();
        ob_end_clean();
        $response->header('Content-Type', 'text/html;charset=utf-8');
        $response->end($res);
    }

}

$obj = new server_http();