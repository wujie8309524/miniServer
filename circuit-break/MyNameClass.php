<?php
class MyNameClass{

    public function getName($name){
        //throwException("error"); 抛出异常，外层捕捉
        10/0; //错误，警告级别，可用set_error_handle处理之后抛出异常
        //var_dump($i+-+);
        return "this is test ".$name;
    }
}