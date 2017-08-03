<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class controllers extends core{
    
    
    
         public function __construct()
         {
         $this->main_path = "controllers/".substr(get_class($this), 0, -2)."/";
         $this->template_path = "controllers/".substr(get_class($this), 0, -2)."/";
         $this->assists_path =  "assists/controllers/".substr(get_class($this), 0, -2)."/";
         parent::__construct();

         }
         
         
         
        protected function module($name)
        {
            $name = $name."_m";
            $module = new $name; 
            $module->cotrollerName = substr(get_class($this), 0, -2);
            return $module;
        }


    
    
    
}
