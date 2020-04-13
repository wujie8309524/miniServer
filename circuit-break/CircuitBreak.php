<?php
class CircuitBreak
{
    /**
     * @param object $obj
     * @param string $method
     * @param array $params
     * @param callable $callback
     * @return mixed
     */
    public function invoke(object $obj,string $method,array $params,callable $callback){

        try{
            $res = $obj->$method(...$params);
            return $res;
        }catch (\Throwable $e){
            //失败之后redis incr
            return $callback();
        }

    }
}