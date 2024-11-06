<?php

namespace Core;

class Autoload
{
 public static function autoload($className)
 {
     $autoloadCommon = function ($className) {
         $path = str_replace('\\', '/', $className);
         $path = './../' . $path . '.php';
         if (file_exists($path)) {
             require_once $path;
             return true;
         }
         return false;
     };

     spl_autoload_register($autoloadCommon);
 }
}