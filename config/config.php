<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$db = FALSE;
$theme = FALSE;
$theme_hooks = array();
$errors = false;

class config
{
    
    protected $db;
    protected $theme;
    protected $theme_hooks;
    protected $errors;

    
    	 public function __construct()
                {
                 global $db;
                 global $theme;
                 global $errors;

                 $this->db = &$db;
                 $this->theme = &$theme;
                 $this->theme_hooks = &$theme_hooks;
                 $this->errors = &$errors;
                         
                 if (! $this->db)
                 {
                     $this->connection();
                 }
                
                 if (! $this->theme)
                 {
                 $this->theme();    
                 }
                
                 if(! $this->errors)
                 {
                 $this->display_errors();
                 }
                 
                }
                
         
         private function display_errors()
         {
             $display_errors = false;
             if($display_errors)
             {
              ini_set('display_errors',1);
              ini_set('display_startup_errors',1);
              error_reporting(-1);
              $this->errors = true;
             }
         }
                
                
         private function connection()
                {
             $db_host = "localhost";
             $db_user ="root";
             $db_pass ="admin";
             $db_name ="datatables";
             $db_port = 3306;
             $db_socket = "";
             
             $this->db = new mydb($db_host, $db_user, $db_pass, $db_name, $db_port, $db_socket);
                }
                
         private function theme()
               {
             
            $theme_name = "authors"; 
           
            
            $r = array();
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $r = explode("\\", str_replace($_SERVER['DOCUMENT_ROOT']."\\", "", __DIR__));
               } else {
            $r = explode('/', str_replace($_SERVER['DOCUMENT_ROOT'].'/', '', __DIR__));
               }
               if ($r[0] == 'config')
               {
            $sitepath = $_SERVER['DOCUMENT_ROOT'];
               }
               else
               {
            $sitepath = $_SERVER['DOCUMENT_ROOT'] . '/' . $r[0];
               }

            
            $this->theme = new Smarty();
            //$this->theme->force_compile = true;
            $this->theme->debugging = false;
            $this->theme->caching = true;
            $this->theme->cache_lifetime = 120;
            $this->theme->setTemplateDir($sitepath."/themes/{$theme_name}/templates/")
                        ->setCompileDir($sitepath."/themes/{$theme_name}/compile/")
                        ->setCacheDir($sitepath."/themes/{$theme_name}/cache/")
                        ->setConfigDir($sitepath."/themes/{$theme_name}/configs/"); 

               }
           
         

}