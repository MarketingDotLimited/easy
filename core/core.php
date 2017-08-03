<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class core extends config
{
    
        public $main_path;
        public $template_path;
        public $assists_path;

        public function __construct()
         {
            parent::__construct();
            $this->themes_hooks();           
         }
         
         
       
         protected function display($path)
         { 
              $this->theme->display($this->template_path.$path);
         }
         
         
         protected function fetch($path)
         { 
           return   $this->theme->fetch($this->template_path.$path);
         }

        
         
         
           public function themes_hooks()
          {
            $hooks_path = array();
            $hooks_path['pre_styles'] = $this->template_path."hooks/pre_styles.tpl";
            $hooks_path['post_styles'] = $this->template_path."hooks/post_styles.tpl";
            $hooks_path['pre_scripts'] = $this->template_path."hooks/pre_scripts.tpl";
            $hooks_path['post_scripts'] = $this->template_path."hooks/post_scripts.tpl";
            $hooks_path['pre_body'] = $this->template_path."hooks/pre_body.tpl";
            $hooks_path['post_body'] = $this->template_path."hooks/post_body.tpl";


               //chec if template in theme_hooks['pre_header'] then not add it again.
            foreach ($hooks_path as $key => $value )
            {
             if (! is_array($this->theme_hooks[$key]))
             {
                 $this->theme_hooks[$key] = array();
             }    
             
             if( $this->theme->templateExists($value) && !in_array($value, $this->theme_hooks[$key]) )
             {   

                $this->theme_hooks[$key][] =   $value;        
             }
            }
            $this->theme->clearAssign('hooks');
            $this->theme->assign('hooks',$this->theme_hooks);
           }

  
         

}

