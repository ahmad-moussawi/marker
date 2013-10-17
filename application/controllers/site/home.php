<?php


class Home extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function Index(){
        $this->loadView('home/index', array('title' => 'Home'));
    }
    
    
    function View($id){
        die('view : ' . $id );
    }
    
    function students(){
        $data['phones'] = $this->db->get('lists_students')->result();
        var_dump($data);
    }
    
}