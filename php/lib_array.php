<?php

class _array{

    function init(){
        return (new self);
    }

    public function produce(){
           return array();
    }

    public function push($array , $needle){
        array_push($array , $needle);
        return true;
    }

    public function shift($array){
        return array_shift($array);
    }

    public function pop($array){
        return array_pop($array);
    }

    public function unshift($array , $needle){
        array_unshift($array , $needle);
        return true;
    }
}