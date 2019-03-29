<?php

$extension_list = get_loaded_extensions();
if (in_array("date" , $extension_list) == false)
{
    exit("php_date is not installed");
}

/* 用法实例 */
/*
 $timer = new date("America/New_York");  // 纽约时区
 echo $timer->format();

 */


class _date{

    public function init(){
        return (new self);
    }

    public function __construct($timezone = "Asia/Shanghai"){ //默认上海时区
           date_default_timezone_set($timezone);
           define("CUR_TIME" , 0);
           define("PREV_TIME" , -1);
           define("NEXT_TIME" , +1);

    }

    public function format($format = "Y-m-d H:i:s" , $cur_time = 0){
           if (!$cur_time) {
                $cur_time = time();
           }
           return date($format , $cur_time);
    }

    public function gtime($const = CUR_TIME){
           switch ($const) {
               case "-1":
                   return date("Y-m-d H:i:s" , strtotime(" -1 day"));
                   break;
               case "+1":
                   return date("Y-m-d H:i:s" , strtotime(" +1 day"));
                   break;
               default:
                   return date("Y-m-d H:i:s" , $this->now());
                   break;
           }
    }

    public function now(){
        return time();
    }



}