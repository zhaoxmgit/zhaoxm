<?php
/*  Php Curl扩展 */
/*
 *@public     方法：init[初始化] . create[打开会话] . debug_dump[调试方法]
 *@private    方法：json_en[数组转JSON] . xml_encode[数组转XML] . xml_decode[xml转数组]
 *@static
 *@protected
 */

/* 检测curl 模块存在与否 */
$extension_list = get_loaded_extensions();
if (in_array("curl" , $extension_list) == false)
{
    exit("php_curl is not installed");
}

/* 用法实例：*/


/*
$curl = new curl();
var_dump($curl->create("https://www.taobao.com" , "post" , array("data" => array("code"=>200,"msg"=>"oh") , "format" => "json")));
// 调试接口
$curl->debug_dump("xml_encode" , array("name" => "lucy" , "age" => 20 , "sex" => "male"));
*/

/* 扩展定义 */
class _curl{

    /* 初始化curl会话 */
    public function init(){
        return (new self);
    }

    /* 发起curl会话 */
    /*
     * $curl   // 请求url
     * $method // 请求方式
     * $header // http请求头格式
     */
    public function create($url = '' , $method = 'get' , $data = array("data" => [] , "format" => "json") ){
        if (!is_string($url) || empty($url)) { //
            return false;
        }
        if (in_array($method , array('get','post','GET','POST')) == false) {
            return false;
        }
        $http_header = array("Content-type:application/". strtolower($data['format']) .";charset=utf-8;","Accept:application/" . strtolower($data['format']));
        $_curl = curl_init();
        curl_setopt($_curl,  CURLOPT_URL, $url);
        curl_setopt($_curl , CURLOPT_HTTPHEADER , $http_header);
        curl_setopt($_curl,  CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($_curl,  CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($_curl,  CURLOPT_RETURNTRANSFER, 1);
        if(strtolower($method) == "post"){
            curl_setopt($_curl, CURLOPT_POST, 1);
            switch (strtolower($data['format'])) {
                case "json":
                    curl_setopt($_curl, CURLOPT_POSTFIELDS, $this->json_encode($data['data']));
                    break;
                case "xml":
                    curl_setopt($_curl, CURLOPT_POSTFIELDS, $this->xml_encode($data['data']));
                    break;
            }
        }
        $output = curl_exec($_curl);

        $_http_res = array
        (
            "errcode" => (string)curl_getinfo($_curl , CURLINFO_HTTP_CODE) ,
            "errmsg"  => curl_getinfo($_curl , CURLINFO_HTTP_CODE)=="200"?"Response Success":"Response Failed" ,
            "data"    => $output?$output:""
        );
        echo json_encode($_http_res , JSON_UNESCAPED_UNICODE);
        curl_close($_curl);
        exit;
    }

    /*  构建数据格式JSON */
    /*
     *
     *
     */

    private function json_encode($array = []){
        if (!empty($array)) {
            return json_encode($array , JSON_UNESCAPED_UNICODE);
        }
        return json_encode(array());
    }

    /* 构建XML格式 */
    /*
     * 仅支持一维数组
     *
     */
    private function xml_encode($array = []){
        if (is_array($array) == false || empty($array) == true) {
            return "";
        }
        $_xml = "<xml>\n";
        foreach ($array as $_item => $_val) {
            $_xml .= "<$_item>";
            $_xml .= "<![CDATA[$_val]]>";
            $_xml .= "</$_item>\n";
        }
        $_xml .= "</xml>";
        return $_xml;
    }

    /*  xml转数组 */

    /*
     *
     *
     */
    private function xml_decode($xml){
        $_return = simplexml_load_string($xml);
        return (array)$_return;
    }

    /*  调试方法 */
    /*
     *
     *
     */
    public function debug_dump($class_method , $param  ){
        if (method_exists($this , $class_method)) {
            var_dump($this->$class_method($param));
        }
    }
}

