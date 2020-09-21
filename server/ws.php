<?php

/**
 * swoole--ws服务
 * Class http
 * @author 伟彬 <277690572@qq.com>
 * @date: 2018/10/25 14:43
 */
class ws
{
    CONST HOST = '0.0.0.0';
    CONST PORT = '9580';
    CONST CHATPORT = '9581';
    public $ws;
    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);
        $this->ws->listen(self::HOST, self::CHATPORT, SWOOLE_SOCK_TCP);
        $this->ws->set([
            'document_root' => '/data/www/swoole/LiveEvents/public',
            'enable_static_handler' => true,
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);

        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('workerstart', [$this, 'onWorkerStart']);
        $this->ws->on('request', [$this, 'onRequest']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);
        $this->ws->start();
    }

    public function onOpen($serv, $frame)
    {
        print_r($serv);
        echo "server: fd{$frame->fd}\n";
        // 将websocket客户端连接标识写入redis
        \app\common\lib\redis\Predis::getInstance()->sAdd(config('redis.live_game_key'), $frame->fd);
    }

    public function onMessage($serv, $frame)
    {
        $serv->push($frame->fd, "this is server message");
    }

    /**
     * 开启workerStart进程
     * @param $serv
     * @param $worker_id
     */
    public function onWorkerStart($serv, $worker_id)
    {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');

        // 加载框架的基础文件
//        require __DIR__ . '/../thinkphp/base.php';
        require __DIR__ . '/../thinkphp/start.php';
    }

    /**
     * request的回调
     * @param $request
     * @param $response
     */
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

        $_FILES = [];
        if (isset($request->files)) {
            foreach ($request->files as $k => $v) {
                $_FILES[$k] = $v;
            }
        }

        $_POST['http_server'] = $this->ws;
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

    public function onClose($serv, $fd)
    {
        echo "client fd{$fd} : close\n";
    }

    /**
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workerId, $data)
    {
        // 分发task任务机制， 让不同的任务 走不同的逻辑
        $obj = new app\common\lib\task\Task();
        $method = $data['method'];
        $result = $obj->$method($data['data'], $serv);
        return true;  // 告诉worker
    }

    /**
     * task任务执行完之后，会自动执行finish函数
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo "taskId:{$taskId}\n";
        echo "finish-data-success:{$data}\n";
    }
}

$obj = new ws();

