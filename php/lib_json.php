<?php

$extension_list = get_loaded_extensions();
if (in_array("json" , $extension_list) == false)
{
    exit("php_json is not installed");
}

class _json{

    public function init(){
        return (new self);
    }

    public function json_en($array){
        if (empty($array)) {
            return json_encode(array());
        }
        return json_encode($array , JSON_UNESCAPED_UNICODE);
    }

    public function json_de($json){
        if (json_decode($json , true) == false) {
            return array();
        }
        return json_decode($json , true);
    }

}