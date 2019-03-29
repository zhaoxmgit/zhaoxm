<?php
/*  Php Curl��չ */
/*
 *@public     ������init[��ʼ��] . create[�򿪻Ự] . debug_dump[���Է���]
 *@private    ������json_en[����תJSON] . xml_encode[����תXML] . xml_decode[xmlת����]
 *@static
 *@protected
 */

/* ���curl ģ�������� */
$extension_list = get_loaded_extensions();
if (in_array("curl" , $extension_list) == false)
{
    exit("php_curl is not installed");
}

/* �÷�ʵ����*/


/*
$curl = new curl();
var_dump($curl->create("https://www.taobao.com" , "post" , array("data" => array("code"=>200,"msg"=>"oh") , "format" => "json")));
// ���Խӿ�
$curl->debug_dump("xml_encode" , array("name" => "lucy" , "age" => 20 , "sex" => "male"));
*/

/* ��չ���� */
class _curl{

    /* ��ʼ��curl�Ự */
    public function init(){
        return (new self);
    }

    /* ����curl�Ự */
    /*
     * $curl   // ����url
     * $method // ����ʽ
     * $header // http����ͷ��ʽ
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

    /*  �������ݸ�ʽJSON */
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

    /* ����XML��ʽ */
    /*
     * ��֧��һά����
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

    /*  xmlת���� */

    /*
     *
     *
     */
    private function xml_decode($xml){
        $_return = simplexml_load_string($xml);
        return (array)$_return;
    }

    /*  ���Է��� */
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

