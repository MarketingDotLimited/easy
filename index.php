<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


include  ("core/autoload.php");
$controller = filter_input(INPUT_GET, 'c');
$route = new routing($controller==""?"default":$controller);

