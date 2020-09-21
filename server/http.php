<?php

/**
 * swoole--http服务
 * Class http
 * @author 伟彬 <277690572@qq.com>
 * @date: 2018/10/25 14:43
 */
class http
{
    CONST HOST = '0.0.0.0';
    CONST PORT = '9580';
    public $http;
    public function __construct()
    {
        $this->http = new swoole_http_server(self::HOST, self::PORT);
        $this->http->set([
            'document_root' => '/data/www/swoole/LiveEvents/public',
            'enable_static_handler' => true,
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);
        $this->http->on('workerstart', [$this, 'onWorkerStart']);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('task', [$this, 'onTask']);
        $this->http->on('finish', [$this, 'onFinish']);
        $this->http->on('close', [$this, 'onClose']);
        $this->http->start();
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

        $_POST['http_server'] = $this->http;
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
        $flag = $obj->$method($data['data']);
        // 将信息记录日志
        file_put_contents('/data/log/sms_send.log', '['.date('Ymd h:i:s').']: '.$flag['msg'].json_encode($flag['data'])."\n",FILE_APPEND);
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

$obj = new http();

