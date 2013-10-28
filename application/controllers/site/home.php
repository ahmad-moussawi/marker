<?php
class Home extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    function Index(){
        redirect('/admin');
        //$this->loadView('home/index', array('title' => 'Home'));
    }
}