<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$modulePath = array();
class modules extends core
{
    public $cotrollerName;
     public function __construct()
         {
         $this->main_path = "core/modules/".substr(get_class($this), 0, -2)."/";
         $this->template_path  = "modules/".substr(get_class($this), 0, -2)."/";
         $this->assists_path = "assists/modules/".substr(get_class($this), 0, -2)."/";
         parent::__construct();
         $this->template_path();

         }
     
    // Assign Module Path For Theme
    protected function template_path()
         {
        global $modulePath;
        $modulePath[substr(get_class($this), 0, -2)]['core'] = $this->template_path;
        $modulePath[substr(get_class($this), 0, -2)]['theme'] = $this->template_path;
        $modulePath[substr(get_class($this), 0, -2)]['assists'] = $this->assists_path;
        $this->theme->clearAssign('modulePath');
        $this->theme->assign('modulePath',$modulePath);
         }
         
    
    public function __call($method,$arguments) {
        if(method_exists($this, $method)) {
          return  call_user_func_array(array($this,$method),$arguments);
        }
    }
 
    
    
}
