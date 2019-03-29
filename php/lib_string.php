<?php

echo (new _string)->gethole();

class _string{
    const PHP_HEL = 4;


    function init(){
        return (new self);
    }

    public function gethole(){
        return self::PHP_HEL;
    }


}