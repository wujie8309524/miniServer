<?php

//可捕捉waning、notice级别错误
set_error_handler('myError'); // myError 必须单引号
function myError($type, $message, $file, $line){
    //var_dump('<b>set_error_handler: ' . $type . ':' . $message . ' in ' . $file . ' on ' . $line . ' line .</b><br />');
    throw new \Exception("error");
}
//可捕捉解析错误、语法错误
//解析错误、语法错误，属于runtime时期错误，这段代码需要放置在include（包含语法错误、解析错误文件之前），先注册错误处理函数。
//inlcude 相当于执行
//因为执行的是test.php，本身没有parsetime错误，是include其他文件，其他文件中出错，属于runtime错误
register_shutdown_function('myShutDown');
function myShutDown()
{
    if ($error = error_get_last()) {
        var_dump('<b>register_shutdown_function: Type:' . $error['type'] . ' Msg: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'] . '</b>');
        //throw new \Exception("error");
    }
}

require_once "CircuitBreak.php";
require_once "MyNameClass.php";

//普通调用
//echo (new test())->getName("abc");
//熔断器调用 fallback 后面 ;
echo (new CircuitBreak())->invoke(new MyNameClass(),"getName",["wj"],function(){ return "fallback";}).PHP_EOL;