<?php

class Index extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //TODO >> Check for logged users
    }

    function Index() {
        if (!Auth::is_authenticated()) {
            $this->loadView('account/login', array('skipClientCheck' => TRUE), 'admin');
        } else {
            $this->loadView('index/index', array(), 'admin');
        }
    }
    

    function JSON() {
        $types =
                array(
                    array('type' => 'VARCHAR', 'constraint' => '255'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'TEXT'),
                    array('type' => 'INT'),
                    array('type' => 'FLOAT'),
                    array('type' => 'FLOAT'),
        );

        echo json_encode($types);
    }

}
