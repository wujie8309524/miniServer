<?php

// 引入Consul工具类
require_once("./ConsulTool.php");

$http = new swoole_http_server("0.0.0.0", 9501);
$http->set(array('worker_num' => 4));


// 监听start事件
// server启动在主进程的主线程回调此函数
$http->on('start', function () {
    $data = array(
        "ID"=>"sw_service1",
        "Name"=>"sw_service1",
        "Tags"=>array("primary"),
        "Address"=>"127.0.0.1",
        "Port"=>9501,
        "Check"=>array("HTTP"=>"http://127.0.0.1:9501/","Interval"=>"5s")
    );

    $consul = new ConsulToolClass();
    $consul->registerService(json_encode($data)); //往Consul里注册服务
});


// 监听request请求
$http->on('request', function ($request, $response) {
    $response->end('ok');
});


// 开始
$http->start();