<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class example_c extends controllers
{
    
    function index()
    {
              
   $x= $this->module("datatables");
   $x->query("SELECT * FROM transactions");
   $x->dataMethod('data');
      
   $draw =$x->draw();
   $filters = $draw['filters'];
   $table = $draw['table'];
   
   $this->theme->assign('dt_filters',$filters);
   $this->theme->assign('dt_table',$table);
   
 
   $this->display('index.tpl');
    
    }
    
    
   function data()
   {
       
   $x= $this->module("datatables");
   $x->query("SELECT * FROM transactions");
  echo $x->data();
       
   }
    
    
}
