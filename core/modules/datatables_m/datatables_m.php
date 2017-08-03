<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//auto load classes from

$data_tables = array();

Class datatables_m  extends modules {
    
    private $query;
    private $param;
    private $dataMethod;
    private $dateField;
    
    public function __construct() {
       parent::__construct(); 
    }
    
    
    public function query($query, $param = Array())
    {
        $this->query = $query; 
        $this->param = $param;
    }
    
    
    public function dataMethod($method)
    {
              $this->dataMethod = $method;
    }
    
    public function dateField($field)
    {
              $this->dateField = $field;
    }
    
    
    private function get_columns()
    {
               $query = $this->db->query($this->query." LIMIT 0", $this->param);
               
               return $query->fields->names;
    }

    
    public function draw()
    {
       global $data_tables;
       $table = array();
       $table['columns'] = $this->get_columns();
       $table['id'] = md5(time() . rand());
       $table['data'] = "index.php?c={$this->cotrollerName}&method=". $this->dataMethod;
       $tables = array();
       $tables[] = $table;
        
        $yesterday['year'] = date('Y', strtotime('-1 days'));
        $yesterday['month'] = date('m', strtotime('-1 days'));
        $yesterday['day'] = date('d', strtotime('-1 days'));
        //This Month first day
        $date['firstDay'] = date('Y-m-d', strtotime("01-{$yesterday['month']}-{$yesterday['year']}"));
        //This month last day
        $date['lastDay'] = date('Y-m-d', strtotime('-1 days'));
        
        $this->theme->assign('date',$date);

       
        $dt['tables'] = $tables;
        $dt['id'] = md5("main_".time() . rand());
        $dt['filters'] = array('date'=>true,'search'=>true);

        $this->theme->assign('dt',$dt);
        
        $draw['filters'] = $this->fetch("filters.tpl");
        $draw['table'] = $this->fetch("main.tpl");
       
        $this->theme->clearAssign('dt');
        $this->theme->clearAssign('date');

        $data_tables[] = $dt;
        $this->theme->clearAssign('data_tables');
        $this->theme->assign('data_tables',$data_tables);
       
        return $draw;
    }
    
    
    public function data()
    {  
      $result = array();
      $sort_query=$this->sort_query($this->get_columns());  
      $limit_query = $this->limit_query();
      $query = $this->db->query($this->query.$sort_query.$limit_query , $this->param);
      $data = $query->rows->ndata;
      $result['recordsTotal'] = count($data);
      $result['recordsFiltered'] = count($data);                  
      $result['draw'] = filter_input(INPUT_POST,'draw');
      $result['data'] = $data;



      $this->db->query("Insert INTO  test (test,test2) VALUES('".json_encode($_POST)."','".json_encode($result)."')");

      return json_encode($result);

    }
    
    
    private function sort_query($columns)
    {
     $sort_field = !filter_input(INPUT_POST, 'iSortCol_0')?0:filter_input(INPUT_POST, 'iSortCol_0');
     $sort_dir = !filter_input(INPUT_POST, 'sSortDir_0')?'asc':filter_input(INPUT_POST, 'sSortDir_0');
      return " ORDER BY ".$columns[$sort_field]." ".$sort_dir." ";
      
        
    }
    
    
    private  function limit_query()
    {
                $start = !filter_input(INPUT_POST,'iDisplayStart')?0:filter_input(INPUT_POST,'iDisplayStart');
                $end = !filter_input(INPUT_POST,'iDisplayLength')?10:filter_input(INPUT_POST,'iDisplayLength');

      return  " LIMIT ".$start.",".$end;
    }




    public function __call($method,$arguments) {
      return   parent:: __call($method,$arguments);
        
    }

    
    
}