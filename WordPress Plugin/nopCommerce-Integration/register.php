<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Class RegisterMethod{
    
    public static $instance;


    public static function get(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        
        return self::$instance;
    }


    public function __construct() {
        
    }
    
    public static function registerUser(){
   // var_dump($_POST);exit;
    }
    public static function addForm(){
        echo do_shortcode('[cr_custom_registration]');
    }
}
RegisterMethod::get();
add_action( 'register_post', 'myplugin_registration_save', 10, 1 );
add_action( 'register_form', 'addForm', 10, 1 );
function myplugin_registration_save( ) {
    RegisterMethod::registerUser();
}

function addForm(){
    RegisterMethod::addForm();
}

