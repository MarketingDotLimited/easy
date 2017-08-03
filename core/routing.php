<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// Controllers routing

class routing
{
    
    	 public function __construct($c)
         {
             $class_name =$c."_c";
             $controller = new $class_name();
             $method = filter_input(INPUT_GET, 'method');
        if($method =="")
             {
	     $method = "index";
             }
		$controller->{$method}();
                

         }
         
    
}