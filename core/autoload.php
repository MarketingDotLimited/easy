<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



// autoload for libraries
// autoload for modules
//auto load for controllers
//auto load for config


function autoload($class)
{
 $path ="";
 $class_file = $class .".php";
if(stristr($class_file,"core.php"))
        $path="core/{$class_file}";
elseif(stristr($class_file,"controllers.php"))
        $path="core/{$class_file}";
elseif(stristr($class_file,"modules.php"))
        $path="core/{$class_file}";
elseif(stristr($class_file,"routing.php"))
        $path="core/{$class_file}";
elseif(stristr($class_file,"_c.php"))
        $path="controllers/{$class}/{$class_file}";
elseif(stristr($class_file,"_m.php"))
        $path="core/modules/{$class}/{$class_file}";
elseif(stristr($class_file,"smarty.php"))
	$path="core/libraries/Smarty/libs/Smarty.class.php";
elseif(stristr($class_file,"mydb.php"))
	$path="core/libraries/mydb/mydb.php";
elseif(stristr($class_file,"_conf.php"))
	$path="config/$class_file";
elseif(stristr($class_file,"config.php"))
	$path="config/$class_file";


    if ($path != "") {
        if (file_exists($path)) {
            require_once($path);
        } else {

            die("File $path , does not exists !");
        }
    }
}



spl_autoload_register('autoload');





