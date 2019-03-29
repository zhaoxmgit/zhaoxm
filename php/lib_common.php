<?php
/* 公共扩展 */
/* TODO 定义扩展  */

$l = new _common;
$l->include_libs();

class _common{
       /* 常量定义 */
      const CFILE = __FILE__;

      /* 在需要初始化的时候应用此方法 */
      public function init()
      {
          return (new self);
      }


      /* 引入lib库 */
     /*
      * @
      *
      */




}