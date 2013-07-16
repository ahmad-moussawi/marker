<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skeleton extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->datatbase();
    }
    
    function Index(){
        
    }
    
    
}
