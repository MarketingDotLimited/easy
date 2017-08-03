<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class default_c extends controllers
{
    
    function index()
    {

        $db_test = $this->db->query( "SELECT * FROM transactions" );
        

        try {
                    $this->display('index.tpl');

        } catch (Exception $ex) {
             echo 'Caught exception: ',  $ex->getMessage(), "\n";
        }
        
        print_r($db_test->rows);

    }
    
}