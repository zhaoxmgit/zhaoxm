<?php


class _gd{

    function init(){
        return (new self);
    }

    public function ver(){ //
        return gd_info();
    }
}