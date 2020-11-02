<?php

    spl_autoload_register('autoload_class');

    function autoload_class($class_name){
            $base_path=  $_SERVER['DOCUMENT_ROOT'].'/gallery/includes/';
            $extension=".class.php";
            $full_file_path=$base_path.$class_name.$extension;
            
            if(file_exists($full_file_path)){
                require_once($full_file_path);
            }
            else{
                exit;
            }
    }

?>